# Config YAML

---

This library is YAML implementation of [config](https://github.com/hurtcode/config) library. It uses yaml file format to
take care of application configurations.

List of abilities of library:

- Implenent bunch of special tag, that help create complex multifile configurations
- The flexibility to add custom logic to compile files

### Usage example:

Create configuration files. All files locates in one configuration directory.

```yaml

# main.yaml
!merge
- !sub common/base
- !env base

# commone/base.yaml
id: 'accounting'
basePath: !var
  key: baseDir
  value: !call
    name: dirname
    args: !interpret $_SERVER['DOCUMENT_ROOT']
components:
  db:
    class: App/Connection/DbClass
  log:
    class: App/Logger
  security:
    class: App/Common/Security

# dev/base.yaml
components:
  db:
    connection:
      port: '5543'
      host: 'localhost'
  log:
    targets: [ 'DEBUG', 'TEST', 'INFO' ]
  security:
    keyDir: !concatenate
      - !var baseDir
      - /kyes/public

```

Than create [configurator class](https://github.com/hurtcode/config/blob/master/src/Configurator.php)
with [config resources](https://github.com/hurtcode/config-yaml/blob/master/src/Config.php)
and [Yaml compiler](https://github.com/hurtcode/config-yaml/blob/master/src/Config.php).

```php

$config = new \Hurtcode\Config\Yaml\Config('config/diractory/path', 'entpryPointFile');
$compiler = new \Hurtcode\Config\Yaml\Compiler(
    new \Hurtcode\Config\Yaml\Tag\AbstractTagProcessorFactory(
        new \Hurtcode\Config\Yaml\Tag\TagProcessorMap()
    )
);

$applicationConfigs = (new \Hurtcode\Config\Configurator($config, $compiler))->run();
```

As result we recieves one php array with configurations

```php
[
    'id' => 'accounting',
    'basePath' => '/var/httpd/sites/example',
    'components' => [
        'db' => [
            'class' => 'App/Connection/DbClass',
            'connection' => [
                'port' => '5543',
                'host' => 'localhost'
            ],
        ],
        'log' => [
            'class' => 'App/Logger',
            'targets' => [
                'DEBUG',
                'TEST',
                'INFO'
            ]
        ],
        'security' => [
            'class' => 'App/Common/Security',
            'keyDir' => '/var/httpd/sites/example/kyes/public'
        ]          
    ]   
];
```

---

### Library work description

This labrary is baseed on [Symfony's YAML](https://github.com/symfony/yaml) and Yaml tags. All tags do specific logic,
like creating configuration variables or string concatanating. Tag functionality is depends on two interfaces
TagProcessorFactoryInterface, that creates processor class for curtain tag and TagProcessorsMapInterface, that need to
tied tag with its processor class (
it is needed only for base TagProcessorFactoryInterface - AbstractTagProcessorFactory). So if need more specific tag or
another processing logic make own implementation of that interfaces

By defualt Config YAML processes next tags:

- call
- env
- concatenate
- merge
- interpret
- sub
- get
- var

All this tags contains in [tag list class](https://github.com/hurtcode/config-yaml/blob/master/src/Tag/Tag.php)

### Tags and processors

**Callable processor**

 ---

**!call**

Helps to call php function in configurations. Function name takes from `name` kay of tag's value Also you can pass
arguments, by `args` key

Tag rules:

- Value has to contain 'name' key.
- 'name' has to be string
- If you pass args as array it has to be indexed (without string keys)

_Example:_

 ```yaml

!call
name: substr
args:
  - string
  - 0
  - 3

 ```

**Sub configuration processor**

---

**!sub**

This processor compiles new configuration and returns it in place where the tag has been used. The configuration file
path is relative to the path to the configuration folder

Tag rules:

- Value has to be string

_Example:_

```yaml

!sub path/in/depth/file

```

**Environment processor**

---

**!env**

This processor takes configuration of from environment directory and compiles it like sub configuration processor.
Environment directory can be passed from di container. By default environment is 'dev'.

Tag rules:

- Value has to be string

_Example:_

 ```yaml

!env config

 ```

**Merge tag processor**

---

**!merge**

Merges tag values in one array. Uses Yiisoft/ArrayHelper.

Tag rules:

- Tag value has to be array or list
- Tag has to contain at least 2 element
- Each element has be array or list

_Example:_

 ```yaml

!merge
- [ some value, another value ]
- { key: value, anotherKey: another value }

 ```

**Concatenate processor**

---

**!concatenate**

Concatenate processor takes list of strings and sums it in one

Tag rules:

- Value has to be array of string

_Example:_

```yaml

!concatenate
- some
- string
- is

```

**Interpret processor**

 ---

**!interpret**

This processor interprets incoming expression as php code. Be careful with this. Incoming strings wraps by
template `return {value};` and sends in `eval` function.

Tag rules:

- Value has to be string

_Example:_

 ```yaml

!interpret '$_SERVER['REQUEST_TIME']'

 ```

**Variable processor**

 ---

**!var**

This processor provides ability to create global configuration variables in yaml. It has two work modes: 1) Set mode; 2)
Get mode.

Tag rules:

- Value has to contain `key` and `value` (IF YOU WANT SET)
- `Key` has to be string (ONLY SET MODE)
- Value has to be string.
- Value has to be in 'container'. It means you has to set variable before call it!.

_Example:_

 ```yaml

# set var
- !var { set: variable, value: some value' }
# get var
- !var variable

 ```

**Get processor**

 ---

**!get**

Get processor helps to get some curtain value from another configuration or list. To use it you have to specify `key` (
what you want) and `from` (where from need to get).

Tag rules:

- Value has to be list with `key` and `from` keys.
- `key` has to be string (for associative array) or int (for indexed array)
- `from` has to be array or list

_Example:_

 ```yaml

!get { key:element, from: { element: value } }

 ```
