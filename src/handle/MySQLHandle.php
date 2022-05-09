<?php
declare(strict_types=1);

namespace Annon\DbManager\handle;

final class MySQLHandle implements DbHandleInterface
{
    /**
     * @var array $config 配置信息
     */
    private array $config = [];

    /**
     * 初始化类
     * @param array $config 数据库配置
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
        // TODO: Implement connect() method.
    }

    /**
     * 查询数据库
     * @param string ...$sql
     * @return mixed
     */
    public function query(string ...$sql): mixed
    {
        // TODO: Implement query() method.
    }

    /**
     * 关闭连接
     * @return void
     */
    public function close(): void
    {
        // TODO: Implement close() method.
    }

    /**
     * 查找一条数据
     * @param string $sql
     * @param int $type
     * @return bool|array|null
     */
    public function find(string $sql, int $type = MYSQLI_ASSOC): bool|array|null
    {
        // TODO: Implement find() method.
    }

    /**
     * 查找多条数据
     * @param string $sql
     * @param int $type
     * @return array
     */
    public function select(string $sql, int $type = MYSQLI_ASSOC): array
    {
        // TODO: Implement select() method.
    }

    /**
     * 插入一条数据并返回插入ID
     * @param string $sql
     * @return string|int
     */
    public function insert(string $sql): string|int
    {
        // TODO: Implement insert() method.
    }

    /**
     * 更新一条数据并返回受影响的行数
     * @param string $sql
     * @return string|int
     */
    public function update(string $sql): string|int
    {
        // TODO: Implement update() method.
    }

    /**
     * 删除数据并返回受影响的行数
     * @param string $sql
     * @return string|int
     */
    public function delete(string $sql): string|int
    {
        // TODO: Implement delete() method.
    }

    /**
     * 获取最后一次操作影响的行数
     * @return int
     */
    public function affected_rows(): int
    {
        // TODO: Implement affected_rows() method.
    }

    /**
     * 获取最后一次查询数据的条数
     * @return int
     */
    public function num_rows(): int
    {
        // TODO: Implement num_rows() method.
    }

    /**
     * 获取上次插入ID
     * @return int|string
     */
    public function insert_id(): int|string
    {
        // TODO: Implement insert_id() method.
    }

    /**
     * 获取本次连接的sql次数
     * @return int
     */
    public function query_count(): int
    {
        // TODO: Implement query_count() method.
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function error(): string
    {
        // TODO: Implement error() method.
    }
}