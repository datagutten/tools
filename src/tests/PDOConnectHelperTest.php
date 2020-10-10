<?php

namespace datagutten\tools\tests;

use datagutten\tools\PDOConnectHelper;
use PHPUnit\Framework\TestCase;

class PDOConnectHelperTest extends TestCase
{
    public function testBuild_dsn()
    {
        $dsn = PDOConnectHelper::build_dsn(['db_type' => 'mssql', 'db_host' => 'localhost', 'db_name' => 'test']);
        $this->assertEquals('mssql:host=localhost;dbname=test', $dsn);;
        $dsn = PDOConnectHelper::build_dsn(['db_type' => 'mssql', 'db_host' => 'localhost', 'db_name' => 'test', 'db_charset' => 'utf-8']);
        $this->assertEquals('mssql:host=localhost;dbname=test;charset=utf-8', $dsn);;
    }
}
