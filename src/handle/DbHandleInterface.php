<?php
declare(strict_types=1);

namespace Annon\DbManager\handle;

interface DbHandleInterface
{
    /**
     * 初始化类
     * @param array $config 数据库配置
     */
    public function __construct(array $config);

    /**
     * 连接数据库
     * @return void
     */
    public function connect(): void;

    /**
     * 查询数据库
     * @param string ...$sql
     * @return mixed
     */
    public function query(string ...$sql): mixed;

    /**
     * 关闭连接
     * @return void
     */
    public function close(): void;

    /**
     * 查找一条数据
     * @param string $sql
     * @param int $type
     * @return bool|array|null
     */
    public function find(string $sql, int $type = MYSQLI_ASSOC): bool|array|null;

    /**
     * 查找多条数据
     * @param string $sql
     * @param int $type
     * @return array
     */
    public function select(string $sql, int $type = MYSQLI_ASSOC): array;

    /**
     * 插入一条数据并返回插入ID
     * @param string $sql
     * @return string|int
     */
    public function insert(string $sql): string|int;

    /**
     * 更新一条数据并返回受影响的行数
     * @param string $sql
     * @return string|int
     */
    public function update(string $sql): string|int;

    /**
     * 删除数据并返回受影响的行数
     * @param string $sql
     * @return string|int
     */
    public function delete(string $sql): string|int;

    /**
     * 获取最后一次操作影响的行数
     * @return int
     */
    public function affected_rows(): int;

    /**
     * 获取最后一次查询数据的条数
     * @return int
     */
    public function num_rows(): int;

    /**
     * 获取上次插入ID
     * @return int|string
     */
    public function insert_id(): int|string;

    /**
     * 获取本次连接的sql次数
     * @return int
     */
    public function query_count(): int;

    /**
     * 获取错误信息
     * @return string
     */
    public function error(): string;
}