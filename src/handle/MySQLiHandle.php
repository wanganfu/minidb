<?php
declare(strict_types=1);

namespace Annon\DbManager\handle;

use mysqli;
use mysqli_result;

final class MySQLiHandle implements DbHandleInterface
{
    /**
     * @var mysqli|null $link 当前连接
     */
    private ?mysqli $link = null;

    /**
     * @var mysqli_result|bool $query_result 查询结果
     */
    private mysqli_result|bool $query_result = false;

    /**
     * @var int $query_count 记录查询次数
     */
    private int $query_count = 0;

    /**
     * @var int $num_rows 查询结果条数
     */
    private int $num_rows = 0;

    /**
     * @var array $config 配置信息
     */
    private array $config = [];

    /**
     * 构造函数
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * 连接数据库
     * @return void
     */
    public function connect(): void
    {
        $mysqli = new mysqli();
        $mysqli->options(MYSQLI_OPT_CONNECT_TIMEOUT, 30);
        $mysqli->options(MYSQLI_OPT_READ_TIMEOUT, 10);
        $mysqli->connect(
            $this->config['host'],
            $this->config['user'],
            $this->config['password'],
            $this->config['dbname'],
            $this->config['port']
        );
        if ($mysqli->connect_errno > 0) {
            die($mysqli->connect_error);
        }
        $mysqli->set_charset($this->config['charset']);
        $this->link = $mysqli;
    }

    /**
     * 查询
     * @param string ...$sql
     * @return mysqli_result|bool|null
     */
    public function query(string ...$sql): mysqli_result|bool|null
    {
        if (!is_object($this->link)) {
            $this->connect();
        }
        $this->query_result = $this->link->query(...$sql);
        $this->query_count++;
        return $this->query_result;
    }

    /**
     * 获取一个查询结果
     * @param string $sql
     * @param int $type
     * @return bool|array|null
     */
    public function find(string $sql, int $type = MYSQLI_ASSOC): bool|array|null
    {
        $result = $this->query($sql);
        $data   = $result->fetch_array($type);
        $this->free_result();
        return $data;
    }

    /**
     * 获取多个查询结果
     * @param string $sql
     * @param int $type
     * @return array
     */
    public function select(string $sql, int $type = MYSQLI_ASSOC): array
    {
        $result = $this->query($sql);
        $data   = $result->fetch_all($type);
        $this->num_rows = $result->num_rows;
        $this->free_result();
        return $data;
    }

    /**
     * 插入一条数据并返回插入的ID
     * @param string $sql
     * @return string|int
     */
    public function insert(string $sql): string|int
    {
        $result = $this->query($sql);
        return $result ? $this->insert_id() : $this->error();
    }

    /**
     * 更新一条数据并返回受影响的行数
     * @param string $sql
     * @return string|int
     */
    public function update(string $sql): string|int
    {
        $result = $this->query($sql);
        return $result ? $this->affected_rows() : $this->error();
    }

    /**
     * 删除一条数据并返回受影响的行数
     * @param string $sql
     * @return string|int
     */
    public function delete(string $sql): string|int
    {
        $result = $this->query($sql);
        return $result ? $this->affected_rows() : $this->error();
    }

    /**
     * 释放查询内存
     * @return void
     */
    private function free_result(): void
    {
        if (is_object($this->query_result)) {
            $this->query_result->free();
            $this->query_result = false;
        }
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function error(): string
    {
        if (!is_object($this->link)) {
            $this->connect();
        }
        return $this->link->error;
    }

    /**
     * 获取上次查询结果行数
     * @return int
     */
    public function num_rows(): int
    {
        return $this->num_rows;
    }

    /**
     * 获取影响行数
     * @return int
     */
    public function affected_rows(): int
    {
        if (!is_object($this->link)) {
            $this->connect();
        }
        return $this->link->affected_rows;
    }

    /**
     * 获取最后一次添加记录的主键号
     * @return int|string
     */
    public function insert_id(): int|string
    {
        if (!is_object($this->link)) {
            $this->connect();
        }
        return $this->link->insert_id;
    }

    /**
     * 获取查询次数
     * @return int
     */
    public function query_count(): int
    {
        return $this->query_count;
    }

    /**
     * 关闭连接
     * @return void
     */
    public function close(): void
    {
        if (is_object($this->link)) {
            $this->link->close();
        }
        $this->link = null;
    }
}