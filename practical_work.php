<?php
/*
Diyorbek Olimov
 */
class Team implements Payable
{
    private $name;
    private $employees;
    private $team = [];

    public function __construct($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function addEmployee(Employee $employee)
    {
        $this->employees[] = $employee;
    }

    public function getSalary()
    {
        $teamSalary = 0;

        foreach ($this->employees as $employee) {
            $teamSalary += $employee->getSalary();
        }

        return $teamSalary;
    }

    public function getEmployees()
    {
        return $this->employees;
    }
}

abstract class Employee
{
    private $fullName;
    private $salary;

    public function __construct($fullName, Payable $salary)
    {
        $this->fullName = $fullName;
        $this->salary = $salary;
    }

    public function getFullName()
    {
        return $this->fullName;
    }

    public function getSalary()
    {
        return $this->salary->getSalary();
    }

    public abstract function getType();

    public abstract function work();
}

abstract class Developer extends Employee
{
    const TYPE = 'Developer';

    public function getType()
    {
        return self::TYPE;
    }
}

abstract class Manager extends Employee
{
    const TYPE = 'Manager';

    public function getType()
    {
        return self::TYPE;
    }
}

class PHPDeveloper extends Developer
{
    public function work()
    {
        echo $this->getFullName() . ' writes PHP code...<br>';
    }
}

class JavaDeveloper extends Developer
{
    public function work()
    {
        echo $this->getFullName() . ' writes Java code...<br>';
    }
}

class ProjectManager extends Manager
{
    public function work()
    {
        echo $this->getFullName() . ' creates tasks...<br>';
    }
}

class HRManager extends Manager
{
    public function work()
    {
        echo $this->getFullName() . ' recruits developers...<br>';
    }
}

class PieceworkPayment implements Payable
{
    private $salary;

    public function __construct($salary)
    {
        $this->salary = $salary;
    }

    public function getSalary()
    {
        return $this->salary;
    }
}

class HourlyPayment implements Payable
{
    private $salary;

    public function __construct($salary, $hours)
    {
        $this->salary = $salary * $hours;
    }

    public function getSalary()
    {
        return $this->salary;
    }
}

interface Payable
{
    public function getSalary();
}

$team = new Team('951-19 team');

$hrManager = new HRManager('Diyorbek', new PieceworkPayment(1000));
$team->addEmployee($hrManager);
$team->addEmployee(new PHPDeveloper('Sanjarbek', new HourlyPayment(10, 160)));
$team->addEmployee(new JavaDeveloper('Rasulbek', new PieceworkPayment(3000)));
$team->addEmployee(new JavaDeveloper('Jahongir', new PieceworkPayment(2500)));
$team->addEmployee(new ProjectManager('Jayhun', new HourlyPayment(9, 150)));

echo '<h2>'.'Total salary of the team "' . $team->getName() . '" = ' . $team->getSalary() . '$</h2>';

foreach ($team->getEmployees() as $employee) {
    $employee->work();
}
?>