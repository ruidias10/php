# LARAVEL

**Courses:**
- https://www.linkedin.com/learning/laravel-9-0-essential-training/

**Exercise Files on GitHub:**
- https://github.com/LinkedInLearning/laravel-9-essential-training-3007804



## Table of Contents
1. Introduction
    1. Docker
    2. Sail
    3. Editor
    4. Laravel
    5. Eloquent
    6. Packages



## 01 - Docker
```bash
$ docker info
$ sudo systemctl status docker
$ sudo systemctl status docker.service
$ sudo systemctl start docker
```

### Docker error
Se `$ docker info` der erro

```bash
$ sudo groupadd -f docker
$ sudo usermod -aG docker $USER
$ newgrp docker
$ groups
$ sudo chown root:docker /var/run/docker.sock
```

### Docker error
[Editar o arquivo de serviço docker](https://phoenixnap.com/kb/docker-permission-denied)

```bash
$ sudo nano /usr/lib/systemd/system/docker.service

[Service]
SupplementaryGroups=docker    
ExecStartPost=/bin/chmod 666 /var/run/docker.sock

$ systemctl daemon-reload
```



## 02 - Sail
```bash
$ nano ~/.zshrc

alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

$ sail ps -a

$ sail up
$ sail up -d

$ sail down

$ sail shell
$ sail root-shell
$ sail tinker

$ sail composer require laravel/breeze 
$ sail artisan breeze:install

$ sail npm install
$ sail npm run dev

$ sail artisan migrate
$ sail artisan make:model Book
$ sail artisan db:seed

$ sail php script.php
```



## 03 - Code editor

### Visual Studio Code
```bash
$ code --list-extensions
  bmewburn.vscode-intelephense-client
  dlasagno.rasi
  editorconfig.editorconfig
  mehedidracula.php-namespace-resolver
  ms-azuretools.vscode-docker
  ms-vscode-remote.remote-containers
  naumovs.color-highlight
  onecentlin.laravel-blade
  onecentlin.laravel5-snippets
  tamasfe.even-better-toml
  vscode-icons-team.vscode-icons
  xdebug.php-debug
  xdebug.php-pack
  yinfei.luahelper
  zobo.php-intellisense
```



## 04 - Laravel

### PHP Extensions
The Laravel framework has a few system requirements. You should ensure that your web server has the following minimum PHP version and extensions:
https://laravel.com/docs/10.x/deployment#server-requirements

```bash
$ (sail) php -v
$ (sail) php -m
```

### Criar e executar projeto `$ composer`
Criar projeto através `$ composer`
```bash
$ composer create-project laravel/laravel example-app
```

Iniciar projeto `$ artisan`
```bash
$ cd example-app
$ php artisan serve
```

### Criar e executar projeto `$ curl`
Criar projeto através `$ curl`
```bash
$ curl -s "https://laravel.build/example-app?with=mysql,redis" | bash
```

Iniciar projeto `$ sail`
```bash
$ cd example-app
$ sail up
$ sail up -d
$ sail artisan migrate
```



### Views
layouts/base.blade.php
```php
@yield('name')
@yield('content')
```

home.blade.php
```php
@extends('layouts.base')

@section('name', 'Rui')

@section('content')
@endsection
```


#### Views Components
components/base.blade.php
```php
<p>Hello, {{ $name }}</p>

<div class="container">
    {{ $content }}
</div>
```

home.blade.php
```php
<x-base>
  
  <x-slot name="name">
    Rui
  </x-slot>
  
  <x-slot name="content">
    <div class="row">
    </div>
  </x-slot>  

</x-base>
```



### Route
Entrada do sistema 
O ficheiro `routes/web.php` é responsável pelas rotas http para a web

```php
# Verbos HTTP
# Route::get, Route::post, Route::patch, Route::delete
Route::get('/hello-world', function() {
  return view('hello-world');
});

# Rota recebe parametro obrigatorio
Route::get('/hello/{name}', function($name){
  return 'Hello ' . $name;
});

# Rota recebe parametro opcional
Route::get('/hello/{name?}', function($name = null){
  return 'Hello ' . $name;
});

# Rota com funcao anonima
Route::get('/hello/{name?}', function($name = null){ 
  return view('hello', ["name" => $name]); 
});

# Rota com Controller
Route::get('/hello/{name?}', [\App\Http\Controllers\HelloController::class, 'hello']);

# Rota::VERBO('URL', CONTROLLER::class, 'METODO DA CLASS HelloController']);
Route::get('/hello', [\App\Http\Controllers\HelloController::class, 'helloWorld']);
Route::get('/hello/{name?}', [\App\Http\Controllers\HelloController::class, 'hello']);
```



### Migrations
as migrations ficam na pasta `database/migrations`
```bash
$ sail artisan make:migration --help
$ sail artisan make:migration create_students_table

# Executa a func down da migration
$ sail artisan migrate:rollback

# Executa a func up da migration
$ sail artisan migrate

$ sail artisan make:migration add_soft_deletes_to_notes
$ sail artisan migrate
```



### Controller
Os controllers ficam na pasta `app/Http/Controllers/`
```bash
$ sail artisan make:controller --help
$ sail artisan make:controller WelcomeController

# Parametro --resource cria um resource controller
$ sail artisan make:controller NoteController --resource
```



### Model
Os controllers ficam na pasta `app/Models`
```bash
$ sail artisan make:model --help
$ sail artisan make:model Student

# Parametro -m cria a Migration
$ sail artisan make:model Note -m 
```










### Artisan
CLI do Laravel

```bash
$ php artisan list
$ php artisan make:controller --help

# Inicia o servidor de desenvolvimento
$ php artisan serve

# Cria um controller
$ php artisan make:controller HelloController
```



### BD
Ficheiros de configuração: `app/.env` `app/config/database.php`



### Migrations
CLI do Laravel

```bash
$ php artisan list
$ php artisan make:controller --help

# Inicia o servidor de desenvolvimento
$ php artisan serve

# Cria um controller
$ php artisan make:controller HelloController
```



## 05 - Eloquent

### Relationship
#### One to one
  - Relationship 1:1.
  - Um ```User``` pode ter uma ```hasOne``` ```Note```
  - Uma ```Note``` pertence ```belongsTo``` a um ```User```

```php
class User {
  // temos acesso a note e ao user dono da nota
  public function note() {
    return $this->hasOne(Note::class); // relacionamento 1:1
  }
}

class Note {
  public function user() {
    return $this->belongsTo(User::class); // relacionamento 1:1
  }
}
```


#### One to many
  - Relationship 1:N. 
  - Um ```User``` pode ter várias ```hasMany``` ```Notes```
  - Uma ```Note``` pertence ```belongsTo``` a um ```User```

```php
class User {
  // temos acesso as notes e ao user dono da nota
  public function notes() {
    return $this->hasMany(Note::class); // relacionamento 1:N
  }
}

class Note {
  public function user() {
    return $this->belongsTo(User::class); // relacionamento N:1
  }
}
```

#### One of many
  - relationship 1:N

#### Many to many
  - relationship N:N

#### Custom types    
  - relationship N:N






## 06 - Packages
Pacotes do Laravel:
```
> laravel-breeze
> Descrição: recursos de autenticação
> Documentação: https://laravel.com/docs/11.x/starter-kits#laravel-breeze
> Instalação:
> `$ (sail) composer require laravel/breeze --dev`
> `$ (sail) artisan breeze:install`
> `$ npm install`
> `$ npm run dev`
```


Pacotes externos, feitos pela comunidade:
```
> laravel-debugbar
> Descrição: barra de debug
> Documentação: https://github.com/barryvdh/laravel-debugbar
> Instalação:
> `$ (sail) composer require barryvdh/laravel-debugbar --dev`
```


Estrutura de pastas `$ tree -L 2`
```bash
.
├── app
│   ├── Console
│   ├── Exceptions
│   ├── Http
│   ├── Models
│   └── Providers
├── artisan
├── bootstrap
│   ├── app.php
│   └── cache
├── composer.json
├── composer.lock
├── config
│   ├── app.php
│   ├── auth.php
│   ├── broadcasting.php
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── filesystems.php
│   ├── hashing.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database
│   ├── factories
│   ├── migrations
│   └── seeders
├── docker-compose.yml
├── package.json
├── phpunit.xml
├── public
│   ├── favicon.ico
│   ├── index.php
│   └── robots.txt
├── README.md
├── resources
│   ├── css
│   ├── js
│   └── views
├── routes
│   ├── api.php
│   ├── channels.php
│   ├── console.php
│   └── web.php
├── storage
│   ├── app
│   ├── framework
│   └── logs
├── tests
│   ├── CreatesApplication.php
│   ├── Feature
│   ├── TestCase.php
│   └── Unit
├── vendor
└── vite.config.js
```