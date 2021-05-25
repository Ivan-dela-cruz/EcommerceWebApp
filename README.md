# ECOMERCE DISTIBUIDORA DE LACTEOS

_Frontend Y BACKEND ECOMMERCE_


## Tecnologías  🚀

_Este apartado describe los requerimientos técnicos necesarios para poner en funcionamiento en tu máquina local para propósitos de desarrollo y pruebas._




### Pre-requisitos 📋

_Que cosas necesitas para instalar el software y como instalarlas_

**COMPOSER** 

**LARAVEL** 7

**Editor de código**  Visual studio code o un IDE configurado para trabajar con tecnologías de JavaScript, HTML,CSS y PHP
 

### Instalación 🔧

_Una serie de ejemplos paso a paso que te dice lo que debes ejecutar para tener un entorno de desarrollo ejecutandose_

_Pasos para clonar el repositorio_

```
abrir terminal
```
```
cd c:\laragon\www
```
```
git clone git@github.com:Ivan-dela-cruz/EcommerceWebApp.git 
```

```
cd EcommerceWebApp
```
_Instalamos el composer_
```
composer install
```
_Una vez instalado creamos el archivo .env_

```
cp .env.example .env
```
_Abrimos y configuramos el archivo .env_

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecommerce //aqui va el nombre de la base de datos
DB_USERNAME=root //usuario de la base de datos
DB_PASSWORD=  //contraseña de la base de datos
```
_Una vez configurado ejecutamos_

```
php artisan key:generate
```
```
php artisan migrate --seed
```
_Finalmente iniciamos el servidor_

```
php artisan serve
```
_Finaliza con un ejemplo de cómo obtener datos del sistema o como usarlos para una pequeña demo_

## Ejecutando las pruebas ⚙️

_Explica como ejecutar las pruebas automatizadas para este sistema_

### Analice las pruebas end-to-end 🔩

_Explica que verifican estas pruebas y por qué_

```
Da un ejemplo
```

### Y las pruebas de estilo de codificación ⌨️

_Explica que verifican estas pruebas y por qué_

```
Da un ejemplo
```

## Despliegue 📦

_Agrega notas adicionales sobre como hacer deploy_

## Construido con 🛠️

_Menciona las herramientas que utilizaste para crear tu proyecto_

* [Laravel](https://laravel.com/docs/7.x/installation) - Framework de desarrollo
* [Livewire](https://laravel-livewire.com/) - El paquete para reactividad basado en php
* [Bootstrap](https://getbootstrap.com/) - Framework del diseño
* [JavaScript](https://www.javascript.com/) - Lenguaje base
* [Axios](https://www.axios.com/) - Paquete de peticiones http


## Contribuyendo 🖇️

Por favor lee el [CONTRIBUTING.md](https://gist.github.com/Ivan-dela-cruz) para detalles de nuestro código de conducta, y el proceso para enviarnos pull requests.


## Versionado 📌

Usamos [SemVer](http://semver.org/) para el versionado. Para todas las versiones disponibles, mira los [tags en este repositorio](https://github.com/tu/proyecto/tags).

## Autores ✒️

_Menciona a todos aquellos que ayudaron a levantar el proyecto desde sus inicios_

* **Gilson Chariguaman** - *Backend Web Service* - [Gilson Chariguaman](https://github.com/gilson97cm)
* **Ivan de la Cruz** - *Desarrollo Frontend and Architecture* - [Ivan-dela-cruz](https://github.com/Ivan-dela-cruz)



## Expresiones de Gratitud 🎁

* Comenta a otros sobre este proyecto 📢
* Invita una cerveza 🍺 o un café ☕ a alguien del equipo. 
* Da las gracias públicamente 🤓.
* etc.



---
⌨️ con ❤️ por [DESARROLADORES] 😊
