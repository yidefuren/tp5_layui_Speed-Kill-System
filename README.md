# thinkphp5 + layui 简陋的秒杀系统
## 环境
* thinkphp5
* redis
* apache
* mysql


## 按照流程
composer install
php think migrate:run


## 秒杀方式
1. mysql 事务+上锁
2. 利用redis原子性操作

## 示例网站
kill.fjbboy.com