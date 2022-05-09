<?php
declare(strict_types=1);

namespace Annon\DbManager;

use Annon\DbManager\handle\DbHandleInterface;
use Annon\DbManager\handle\MySQLHandle;
use Annon\DbManager\handle\MySQLiHandle;

final class DbFactory
{
    /**
     * @var DbFactory|null The singleton instance
     */
    private static ?DbFactory $dbf = null;

    /**
     * @var DbHandleInterface|null The database adapter
     * @pst-var DbAdapter $db
     */
    protected ?DbHandleInterface $db = null;

    /**
     * @var string The database type
     */
    private string $driver = "mysqli";

    /**
     * @param string $driver The database type
     */
    private function __construct(string $driver)
    {
        $this->driver = $driver;
    }

    /**
     * 获取工厂
     * @param string $driver
     * @return DbFactory|null
     */
    public static function getInstance(string $driver = "mysqli"): ?DbFactory
    {
        if (DbFactory::$dbf === null) {
            DbFactory::$dbf = new DbFactory($driver);
        }
        return DbFactory::$dbf;
    }

    /**
     * 获取MySQL类的对象
     * @param array $config mysql配置
     * @return DbHandleInterface|null
     */
    public function getDb(array $config): ?DbHandleInterface
    {
        if ($this->db === null) {
            $this->db = match ($this->driver) {
                'mysql' => new MySQLHandle($config),
                default => new MySQLiHandle($config),
            };
            $this->db->connect();
        }
        return $this->db;
    }
}