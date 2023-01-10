<?php

/**
 * feile name 数据库的封装模块
 * author CloudZA(之安)
 */
require_once('config.php'); //数据库配置
class Db
{
    private $host;      //主机地址
    private $port;      //端口号
    private $user;      //用户名
    private $pwd;       //密码
    private $dbname;    //数据库名
    private $charset;   //字符集
    private $objdb;     //连接对象
    private $link;
    private $table_name;
    private $options;
    private static $instance;
    //声明私有构造方法为了防止外部代码使用new来创建对象
    private function __construct($param)
    {
        $this->initParam($param);
        $this->initConnect();
    }
    //宏
    private function __clone()
    {
    }

    // 声明一个静态方法，用于检测是否有实例对象
    public static function getInstance($param = array())
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self($param);
        }
        return self::$instance;
    }

    //初始化参数
    private function initParam($param)
    {
        $this->host = $param['host'] ?? 'localhost';
        $this->port = $param['port'] ?? '3306';
        $this->user = $param['user'] ?? 'root';
        $this->pwd = $param['pwd'] ?? 'root';
        $this->dbname = $param['dbname'] ?? 'root';
        $this->charset = $param['charset'] ?? 'utf8';
    }

    //连接数据库
    private function initConnect()
    {
        if (!$this->objdb = @mysqli_connect($this->host, $this->user, $this->pwd, $this->dbname)) {
            switch ($this->geterrno()) {
                case 2005:
                    exit("连接数据库失败，数据库地址或者数据库服务器不可用");
                    break;
                case 2003:
                    exit("连接数据库失败，数据库端口错误");
                    break;
                case 2006:
                    exit("连接数据库失败，数据库服务不可用");
                    break;
                case 1045:
                    exit("连接数据库失败，数据库用户名或密码错误");
                    break;
                default:
                    exit("数据库连接失败，请检查数据库信息。错误码：" . $this->geterrno());
                    break;
            }
        }
        if ($this->getMysqlVersion() > '4.1') {
            mysqli_set_charset($this->objdb, $this->charset);
        }
        @mysqli_select_db($this->objdb, $this->dbname) or exit("连接数据库失败，未找到您填写的数据库");
    }

    //获取数据库版本信息
    function getMysqlVersion()
    {
        return mysqli_get_server_info($this->objdb);
    }

    //获取mysql错误编码
    private function geterrno()
    {
        return mysqli_connect_errno();
    }
    //获取mysql错误信息以及编码
    private function getMysqlError($sql)
    {
        $error = mysqli_error($this->objdb);
        $errno = mysqli_errno($this->objdb);
        // json输出
        $udata = array('code' => $errno, 'msg' => $sql);
        $jdata = json_encode($udata, 320);
        // return "错误码：" . $errno . "<br>" . $error . "<br>错误的语句：" . $sql;
        return $jdata;
    }

    //输出Json
    public function Output_Json($code, $string)
    {
        if (!empty($code) && !empty($string)) {
            $udata = array('code' => $code, 'data' => $string);
            $json = json_encode($udata, 320);
            return $json;
        } else {
            $udata = array('code' => '-1', 'data' => 'please enter the complete parameter');
            $json = json_encode($udata, 320);
            return $json;
        }
    }

    //设置JOIN条件(数组和多个JOIN都可以)，JOIN('id',12)  或者 JOIN([id=>12])
    public function join($key = null, $factor = '', $val = '')
    {
        $v = (string)$val;
        if ($key != '' && $factor != '' && $v != '') { //属于三者都有的情况，中间的参数就是条件
            if (is_string($key) && is_string($factor) && is_string($v)) {
                $v_str = "`$key` $factor ON ($val)";
            } else {
                die("failed: " . '不合法');
            }
        } else { //两个或者一个参数的情况
            $val = (string)$factor; //此种情况将第二参数传给第三个参数
            if (is_string($key) && !is_array($key) && $val != '') {
                if (strpos($key, " ")) {
                    $v_str = "$key ON ($val)";
                } else {
                    $v_str = "`$key` ON ($val)";
                }
            } elseif (is_string($key) && !is_array($key) && $val == '') {
                $v_str = "$key ";
            } else if (is_array($key)) {
                $count_key = count($key);
                $nums = 1;
                $str = '';
                foreach ($key as $k => $v) {
                    if ($count_key == $nums) {
                        $str .= "`$k` ON ($v)";
                    } else {
                        $str .= "`$k` ON ($v)" . ' ' . 'LEFT JOIN' . ' ';
                    }
                    $nums++;
                }
                $nums = 1;
                $v_str = $str;
            } else {
                $v_str = '';
            }
        }
        $this->options['join'][] = $v_str;
        return $this;
    }

    //处理JOIN数据，组sql
    public function deal_join($join)
    {
        $arr = $join['join'];
        $count_key = count($arr);
        $nums = 1;
        $str = '';
        foreach ($arr as $key => $val) {
            if ($count_key == $nums) {
                $str .= $val;
            } else {
                $str .= $val . ' ' . 'LEFT JOIN' . ' ';
            }
            $nums++;
        }
        $nums = 1;
        return 'LEFT JOIN ' . $str;
    }

    //设置分页查询、格式->('0,10')
    public function limit($limit, $nums = '')
    {
        if ((string)$nums == '' && (string)$limit != '') {
            $this->options['limit'] = '0' . ',' . (string)$limit;
        } else {
            $this->options['limit'] = (string)$limit . ',' . (string)$nums;
        }
        return $this;
    }

    //处理limit数据，组sql
    public function deal_limit($limit)
    {
        $limit = $limit['limit'];
        return 'limit ' . $limit;
    }

    //原生增删改
    public function execute($sql)
    {
        if (!$rs = mysqli_query($this->objdb, $sql)) {
            echo $this->getMysqlError($sql);
        }
        return $rs;
    }

    /**
     * 执行增删改操作
     * @return bool 成功返回
     */
    public function exec($sql)
    {
        $key = substr($sql, 0, 6);
        if (in_array($key, array('inisert', 'update', 'delete')))
            return $this->execute($sql);
        else {
            exit('Error');
        }
    }

    //判断表存在否
    public function exist($table, $true = true)
    {
        $array = $this->do_sql();
        $sql = 'SELECT * from ' . $table;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_exist($this->objdb, $sql);
    }
    //判断表存在否sql操作
    public function query_exist($obj, $sql)
    {
        $result = mysqli_query($obj, $sql);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    //处理options，组成sql语句(公共函数)
    public function do_sql()
    {
        $array = $this->options;
        if (empty($array)) {
            return [];
        }
        $this->options = []; //清除记录
        $data = [];
        $stra = '';
        $strb = '';
        foreach ($array as $key => $val) {
            $deal_something = 'deal_' . $key;
            if ($key == 'field') {
                $stra .= $this->$deal_something($array) . ' ';
                $data['field'] = $stra;
            } else {
                $strb .= $this->$deal_something($array) . ' ';
                $data['make'] = $strb;
            }
        }
        return $data;
    }

    /**
     * 添加插入数据 
     * @add 数组(['xx'=>'xx','xx'=>'xx'])
     * @table 表名
     */
    public function add($add, $true = true)
    {
        if (!is_array($add)) {
            return false;
        }
        $table = $this->table_name;
        $data = $this->deal_add($add);
        $sql = 'INSERT INTO ' . $table . ' ' . $data['key'] . ' VALUES ' . $data['val'];
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_add($this->objdb, $sql);
    }
    //添加插入数据 sql操作
    public function query_add($obj, $sql)
    {
        $result = mysqli_query($obj, $sql);
        if ($result && mysqli_affected_rows($obj) > 0) {
            $res = mysqli_insert_id($obj);

            return $res;
        } elseif (!$result) {
            exit($this->getMysqlError($sql));
        } else {
            return false;
        }
    }
    //处理add()数据 组sql
    public function deal_add($add)
    {
        $nums = 1;
        $counts = count($add);
        $stra = '';
        $strb = '';
        foreach ($add as $key => $val) {
            if ($nums == 1) {
                $stra .= '(`' . (string)$key . '`';
                $strb .= '(' . (string)"'$val'";
            } elseif ($nums == $counts) {
                $stra .= ',`' . (string)$key . '`)';
                $strb .= ',' . (string)"'$val'" . ')';
            } else {
                $stra .= ',`' . (string)$key . '`';
                $strb .= ',' . (string)"'$val'";
            }
            $nums++;
        }
        $data['key'] = $stra;
        $data['val'] = $strb;
        return $data;
    }

    /**
     * 更新表中的数据
     * @table 表名
     * @data 数组( ['name'=>'张三',time=>'1234567890'] )
     */
    public function update($data, $true = true)
    {
        if (!is_array($data)) {
            return false;
        }
        $table = $this->table_name;
        $data = $this->deal_update($data);
        $array = $this->do_sql();
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'UPDATE ' . $table . ' SET ' . $data . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_update($this->objdb, $sql);
    }
    //更新操作 sql操作
    public function query_update($data, $sql)
    {
        $result = mysqli_query($data, $sql);
        $effet = mysqli_affected_rows($data);
        if ($result && $effet > 0) {
            $res = $effet;
            //$this->close_db($data);
            return $res;
        } elseif (!$result) {
            exit($this->getMysqlError($sql));
        } else {
            return false;
        }
    }
    //处理更新数据，组sql
    public function deal_update($data)
    {
        $nums = 1;
        $counts = count($data);
        $str = '';
        foreach ($data as $key => $val) {
            if ($nums == $counts) {
                $str .= $key . ' = ' . (string)"'$val'";
            } else {
                $str .= $key . ' = ' . (string)"'$val'" . ' , ';
            }
            $nums++;
        }
        return $str;
    }

    /**
     * 删除数据表中的数据
     * @table 表名
     * @data 数组 ( ['name'=>'张三',time=>'1234567890'] )
     */
    public function del($true = true)
    {
        $data = $this->deal_del();
        $link = $this->objdb;
        $table = $this->table_name;
        $sql = 'DELETE FROM ' . $table . ' ' . $data;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_del($link, $sql);
    }
    //删除函操作 sql操作
    public function query_del($link, $sql)
    {
        $res = mysqli_query($link, $sql);
        $effet = mysqli_affected_rows($link);
        if ($res) {
            //$this->close_db($link);
            return $effet;
        } else {
            return false;
        }
    }


    //处理删除函数
    public function deal_del()
    {
        $array = $this->options;
        if (empty($array)) {
            return '';
        }
        $res = $this->deal_where($array);
        return $res;
    }


    /**
     * 设置where条件
     * (数组和多个where都可以)，where('id',12)  或者 where([id=>12])
     */
    public function where($key, $factor = null, $val = null)
    {
        if ($key != null && $factor != null && is_array($val)) { //属于三者都有的情况，中间的参数就是条件
            if (is_string($key) && is_string($factor)) {
                $v_str = "`$key` $factor ";
            } else {
                die("failed: " . '不合法');
            }
            $count_val = count($val);
            $nums = 1;
            $str = '';
            foreach ($val as $k => $v) {
                if ($count_val == $nums) {
                    $str .= "'$v'";
                } else {
                    $str .= "'$v'" . ' ' . 'and' . ' ';
                }
                $nums++;
            }
            $nums = 1;
            $v_str = $v_str . $str;
        } elseif ($key != null && $factor != null && $val != null && !is_array($val)) {
            $v = (string)$val;
            if (is_string($key) && is_string($factor) && is_string($v)) {
                if ($factor == 'in') {
                    $v_str = "$key $factor $val";
                } else {
                    $v_str = "$key $factor '$val'";
                }
            } elseif (is_array($key) && is_string($factor) && is_string($val)) {
                $count_key = count($key);
                $nums = 1;
                $str = '';
                foreach ($key as $k => $v) {
                    if ($count_key == $nums) {
                        $str .= "$k ='$v'";
                    } else {
                        $str .= "$k ='$v'" . ' ' . 'and' . ' ';
                    }
                    $nums++;
                }
                $nums = 1;
                $v_str = $factor . $str . $val;
            } else {
                die("failed: " . '不合法');
            }
        } else { //两个或者一个参数的情况
            $v = (string)$val;
            $val = (string)$factor; //此种情况将第二参数传给第三个参数
            if (is_string($key) && !is_array($key)) { //为字符串
                $v_str = "$key = '$val'";
            } else if (is_array($key)) {
                $count_key = count($key);
                $nums = 1;
                $str = '';
                foreach ($key as $k => $v) {
                    if ($count_key == $nums) {
                        $str .= "$k ='$v'";
                    } else {
                        $str .= "$k ='$v'" . ' ' . 'and' . ' ';
                    }
                    $nums++;
                }
                $nums = 1;
                $v_str = $str;
            } else {
                die("failed: " . '不合法');
            }
        }
        $this->options['where'][] = $v_str;
        return $this;
    }
    //处理where数据，组sql
    public function deal_where($where)
    {
        $arr = $where['where'];
        $count_key = count($arr);
        $nums = 1;
        $str = '';
        foreach ($arr as $key => $val) {
            if ($count_key == $nums) {
                $str .= $val;
            } else {
                $str .= $val . ' ' . 'and' . ' ';
            }
            $nums++;
        }
        $nums = 1;
        return 'where ' . $str;
    }

    /**
     * 设置orwhere条件(数组和多个where都可以)，where('id',12)  或者 where([id=>12])
     */
    public function whereOr($key, $factor = '', $val = '')
    {
        $v = (string)$val;
        if ($key != '' && $factor != '' && $v != '') { //属于三者都有的情况，中间的参数就是条件
            if (is_string($key) && is_string($factor) && is_string($v)) {
                $v_str = "$key $factor '$val'";
            } elseif (is_array($key) && is_string($factor) && is_string($v)) {
                $count_key = count($key);
                $nums = 1;
                $str = '';
                foreach ($key as $k => $v) {
                    if ($count_key == $nums) {
                        $str .= "$k = '$v'";
                    } else {
                        $str .= "$k = '$v'" . ' ' . 'or' . ' ';
                    }
                    $nums++;
                }
                $nums = 1;
                $v_str = $factor . $str . $val;
            } else {
                die("failed: " . '不合法');
            }
        } else { //两个或者一个参数的情况
            $val = (string)$factor; //此种情况将第二参数传给第三个参数
            if (is_string($key) && !is_array($key)) { //为字符串
                $v_str = "$key ='$val'";
            } else if (is_array($key) && !empty($val)) {
                $count_key = count($key);
                $nums = 1;
                $str = '';
                foreach ($key as $k => $v) {
                    if ($count_key == $nums) {
                        $str .= "$k = '$v'";
                    } else {
                        $str .= "$k = '$v'" . ' ' . 'or' . ' ';
                    }
                    $nums++;
                }
                $nums = 1;
                $v_str = $str . $val;
            } else if (is_array($key) && empty($val)) {
                $count_key = count($key);
                $nums = 1;
                $str = '';
                foreach ($key as $k => $v) {
                    if ($count_key == $nums) {
                        $str .= "$k = '$v'";
                    } else {
                        $str .= "$k = '$v'" . ' ' . 'or' . ' ';
                    }
                    $nums++;
                }
                $nums = 1;
                $v_str = $str;
            } else {
                die("failed: " . '不合法');
            }
        }
        $this->options['whereOr'][] = $v_str;
        return $this;
    }
    //处理orwhere数据，组sql
    public function deal_whereOr($whereOr)
    {
        $arr = $whereOr['whereOr'];
        $count_key = count($arr);
        $nums = 1;
        $str = '';
        foreach ($arr as $key => $val) {
            if ($count_key == $nums) {
                $str .= $val;
            } else {
                $str .= $val . ' ' . 'or' . ' ';
            }
            $nums++;
        }
        $nums = 1;
        return 'or ' . $str;
    }

    //聚合查询-count
    public function count($true = true)
    {
        $link = $this->objdb;
        $table = $this->table_name;
        $array = $this->do_sql();
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . 'count(*)' . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_count($link, $sql);
    }
    //聚合查询-count sql操作
    public function query_count($link, $sql)
    {
        $result = mysqli_query($link, $sql);
        if ($result) {
            $count_json = mysqli_fetch_assoc($result);
            $count = $count_json['count(*)'];
        } else {
            // exit('error');
            exit($this->getMysqlError($sql));
        }
        return (int)$count;
    }
    //聚合查询-max
    public function max($max, $true = true)
    {
        $link = $this->objdb;
        $table = $this->table_name;
        $array = $this->do_sql();
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . 'max(' . $max . ')' . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_max($link, $sql, $max);
    }
    //聚合查询-max sql操作
    public function query_max($link, $sql)
    {
        $result = mysqli_query($link, $sql);
        if ($result) {
            $count_json = mysqli_fetch_assoc($result);
            $str_arr = explode(' ', $sql);
            $key_str = $str_arr[1];
            $count = $count_json[$key_str];
        } else {
            // exit('error');
            exit($this->getMysqlError($sql));
        }
        return (int)$count;
    }


    //聚合查询-min
    public function min($min, $true = true)
    {
        $link = $this->objdb;
        $table = $this->table_name;
        $array = $this->do_sql();
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . 'min(' . $min . ')' . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_min($link, $sql, $min);
    }
    //聚合查询-min sql操作
    public function query_min($link, $sql)
    {
        $result = mysqli_query($link, $sql);
        if ($result) {
            $count_json = mysqli_fetch_assoc($result);
            $str_arr = explode(' ', $sql);
            $key_str = $str_arr[1];
            $count = $count_json[$key_str];
        } else {
            // exit('error');
            exit($this->getMysqlError($sql));
        }
        return (int)$count;
    }


    //聚合查询-sum
    public function sum($sum, $true = true)
    {
        $link = $this->objdb;
        $table = $this->table_name;
        $array = $this->do_sql();
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . 'sum(' . $sum . ')' . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_sum($link, $sql, $sum);
    }
    //聚合查询-sum sql操作
    public function query_sum($link, $sql)
    {
        $result = mysqli_query($link, $sql);
        if ($result) {
            $count_json = mysqli_fetch_assoc($result);
            $str_arr = explode(' ', $sql);
            $key_str = $str_arr[1];
            $count = $count_json[$key_str];
        } else {
            // exit('error');
            exit($this->getMysqlError($sql));
        }
        return (int)$count;
    }


    //聚合查询-avg
    public function avg($avg, $true = true)
    {
        $link = $this->objdb;
        $table = $this->table_name;
        $array = $this->do_sql();
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . 'avg(' . $avg . ')' . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_avg($link, $sql, $avg);
    }
    //聚合查询-avg sql操作
    public function query_avg($link, $sql)
    {
        $result = mysqli_query($link, $sql);
        if ($result) {
            $count_json = mysqli_fetch_assoc($result);
            $str_arr = explode(' ', $sql);
            $key_str = $str_arr[1];
            $count = $count_json[$key_str];
        } else {
            // exit('error');
            exit($this->getMysqlError($sql));
        }
        return (int)$count;
    }


    //field:格式->('id,name,time......')
    public function field($field)
    {
        $this->options['field'] = $field;
        return $this;
    }

    //处理field数据，组sql
    public function deal_field($field)
    {
        $field = $field['field'];
        return $field;
    }
    //设置排序 格式->('id desc,time aes')      //ORDER BY ticketnum_id desc,project_id desc
    public function order($order)
    {
        $this->options['order'] = $order;
        return $this;
    }
    //处理order数据，租sql
    public function deal_order($order)
    {
        $order = $order['order'];
        return 'ORDER BY ' . $order;
    }
    /**
     * 查找单条
     * @table 表名
     */
    public function find($true = true)
    {
        $table = $this->table_name;
        $array = $this->do_sql();
        $field = isset($array['field']) ? $array['field'] : '*';
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . $field . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_find($this->objdb, $sql);
    }
    //查找单条数据sql操作
    public function query_find($data, $sql)
    {
        $result = mysqli_query($data, $sql);
        if ($result) {
            $arr = [];
            if ($result && mysqli_num_rows($result) > 0) {
                $arr = mysqli_fetch_assoc($result);
            }
        } elseif (!$result) {
            exit($this->getMysqlError($sql));
        }
        //$this->close_db($data);
        return isset($arr) ? $arr : false;
    }
    //查询多条
    public function select($true = true)
    {
        $table = $this->table_name;
        $array = $this->do_sql();
        $field = isset($array['field']) ? $array['field'] : '*';
        $make = isset($array['make']) ? $array['make'] : '';
        $sql = 'SELECT ' . $field . ' from ' . $table . ' ' . $make;
        if ($true == false) {
            return $sql;
        } //输出sql
        return $this->query_select($this->objdb, $sql);
    }
    //查找多条数据sql操作
    public function query_select($link, $sql)
    {
        $result = mysqli_query($link, $sql);
        $arr = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $arr[] = $row;
            }
        } elseif (!$result) {
            exit($this->getMysqlError($sql));
        }

        return $arr;
    }

    //返回数据库实例对象
    public static function table($table_name, $val = FALSE)
    {
        $link = self::getInstance();
        if ($val) {
            $link->table_name = "`$table_name` $val";
        } else {
            $link->table_name = "`$table_name`";
        }
        return $link;
    }
    //原生sql操作
    public static function query($sql){
        $obj = self::getInstance();
        $link = $obj->objdb;
        $str_arr = explode(' ', $sql);
        $data = ['INSERT'=>'query_add','DELETE'=>'query_del','UPDATE'=>'query_update','SELECT'=>['count('=>'query_count','max('=>'query_max','min('=>'query_min','sum('=>'query_sum','avg('=>'query_avg']];
        $func_name = '';
        $a = strtoupper($str_arr[0]);
        $b = strtolower($str_arr[1]);
        foreach($data as $key=>$val){
            if($key == $a){
                if(is_string($val)){//属于增删改
                    $func_name = $val;break;
                }else if(is_array($val)){//属于查
                    foreach($val as $k=>$v){
                        if(strpos($b,$k) === 0){
                            $func_name = $v;break;
                        }else{
                            $func_name = 'query_select';
                        }
                    }
                }
            }
        }
        if($func_name === ''){//sql不合法
            die("sql: ".'不合法');
        }else{
            return $obj->$func_name($link,$sql);
        }
    }
    //数据库安装
    public static function establish($sql){
        $link = self::getInstance()->objdb;
        return mysqli_query($link,$sql);
    }
    //关闭连接
    public function close_db($link){
        mysqli_close($link);
    }
}
