<br/>
<p align="center">
  <a href="https://github.com/ZeadShalaby/API_REVIVE_SYSTEM">
          <img src="https://i.imgur.com/rAwLRCT.png" alt="Logo" width="400" height="300">
  </a>
    
<h3 align="center">API REVIVE SYSTEM</h3>

  <p align="center">
     Project Laravel | socialite (github,google) | Event Listener (View)  | use hardware | machine learning
    <br/>
    <br/>
  </p>
  

![Forks](https://img.shields.io/github/forks/ZeadShalaby/API_REVIVE_SYSTEM?style=social) ![Issues](https://img.shields.io/github/issues/ZeadShalaby/API_REVIVE_SYSTEM) ![License](https://img.shields.io/github/license/ZeadShalaby/API_REVIVE_SYSTEM)

## Table Of Contents

* [About the Project](#about-the-project)
* [Built With](#built-with)
* [Getting Started](#getting-started)
    * [Prerequisites](#prerequisites)
    * [Installation](#installation)      
* [Dashboard](#dashboard)
    * [Admin](#admin)
    * [Owner](#owner)
    * [Client](#client)
    * [Auth](#Auth)
    * [Machine](#machine)    
* [Usage](#usage)
    * [Locally](#running-locally)
    * [Via Container](#running-via-container)  
* [Contributingس](#contributing)
* [Authors](#authors)
<!--* [Screenshots](#Screenshots)-->

<!--
## Screenshots
<p>
# Screenshots

📌Home Page:

<img src="https://i.imgur.com/bfGGH7U.png" alt="project(Coise-User)" width="1000" height="450">



📌Login Page:


<img src="https://i.imgur.com/O680nDN.png" alt="project(Coise-User)" width="1000" height="400">




📌Departments Page: 



<img src="https://i.imgur.com/VXNDEjT.png" alt="project(Coise-User)" width="1000" height="400">



📌Orders Page: 



<img src="https://i.imgur.com/QJTlibX.png" alt="project(Coise-User)" width="1000" height="400">



📌User Page: 



<img src="https://i.imgur.com/n7z8WjA.png" alt="project(Coise-User)" width="1000" height="400">



📌Favourite Page: 



<img src="https://i.imgur.com/TqZCrfC.png" alt="project(Coise-User)" width="1000" height="400">



📌Event Page: 



<img src="https://i.imgur.com/7xbb9nU.png" alt="project(Coise-User)" width="1000" height="400">





</p>
-->
## About The Project

Analyzing greenhouse gases at industrial & touristic areas & Revive environment ,
We have a machine consisting of some sensors that read the percentages of greenhouse gases and temperatures in industrial or tourist places. The machine relies on entering this data into API daily to use this data that was recorded to train the data using machine learning to know the permissible percentages in the secretion of oxide gases or greenhouse gases

## Built With

**Client:** flutter , react.js

**Server:** Apache, Laravel

**Containerization Service:** Docker

**Miscellaneous:** Github
Actions, [Build and push Docker images](https://github.com/marketplace/actions/build-and-push-docker-images), [Docker Login](https://github.com/marketplace/actions/docker-login)

## Getting Started

To get a local copy up and running follow these simple example steps.

### Prerequisites

* npm

```sh
npm install npm@latest -g
```

* laravel

```sh
composer global require laravel/installer
```

Make sure that either **MySQL** or **MariaDB** are installed either manually or via **phpMyAdmin**

### Installation

Clone the project

```bash
  https://github.com/ZeadShalaby/API_REVIVE_SYSTEM
```

Go to the project directory

```bash
  cd API_REVIVE_SYSTEM
```

Install dependencies

```bash
  composer install
```

```bash
  npm install
```

## Usage

### Running Locally

Make the migrations to update the database

```bash
    php artisan migrate
```

Seed the Database

```bash
    php artisan db:seed
```

Start the server and run watch

```bash
    php artisan serve
```

```bash
    npx run watch
````

or alternatively run the .bat

```bash
    /autorun.bat
```

go to the following route

```
    http://127.0.0.1:8000/
```

### Running via container

pull the image 

```
docker pull zeadshalaby/revive 
``` 

 run the container

 ```
 docker run --name revive -p 8000:8000 -d zeadshalaby/revive
 ```
 
 connect to Container Terminal
 
 ```
 docker exec -it revive /bin/sh
 ```
 
 make the migrations to update the database

```bash
    php artisan migrate
```

 go to the following page
 ```
 <container-ip>:8000
 ```
## Contributings

Any contributions you make are **greatly appreciated**.

* If you have suggestions for adding or removing projects, feel free
  to [open an issue](https://github.com/ZeadShalaby/API_REVIVE_SYSTEM/issues/new) to discuss it, or directly
  create a pull request after you edit the *README.md* file with necessary changes.
* Please make sure you check your spelling and grammar.
* Create individual PR for each suggestion.
* Make sure to add a meaningful description

### Creating A Pull Request

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/GoalFeature`)
3. Commit your Changes (`git commit -m 'Add some GoalFeature'`)
4. Push to the Branch (`git push origin feature/GoalFeature`)
5. Open a Pull Request
   
## Dashboard

To get a local copy up and running follow these simple example steps.

### Admin

📌 request

```bash
....
```

📌request

```bash
....
```

📌 request

```bash
....
```

📌request

```bash
....
```


### Owner

📌 request

```bash
....
```

📌request

```bash
....
```

📌 request

```bash
....
```

📌request

```bash
....
```

### Client

📌 request

```bash
....
```

📌request

```bash
....
```

📌 request

```bash
....
```

📌request

```bash
....
```


### Auth 

📌 request

```bash
....
```

📌request

```bash
....
```

📌 request

```bash
....
```

📌request

```bash
....
```

### Machine

📌 request

```bash
....
```

📌request

```bash
....
```

📌 request

```bash
....
```

📌request

```bash
....
```


## Authors
* **Ziad Shalaby** - *Computer Science Student* - [Ziad Shalaby](https://github.com/ZeadShalaby)
* **Salma Hamdy** - *Computer Science Student* - [Salma Hamdy](https://github.com/salmaserag)
* **Said Sharaf** - *Computer Science Student* - [Said Sharaf](https://github.com/Saidsharaf)
* **Rowyda Ehab** - *Computer Science Student* - [Rowyda Ehab](https://github.com/RowydaEhab8)
* **Ali Hammed** - *Computer Science Student* - [Ali Hammed](https://github.com/Aliatia20)
* **Sahar Fayez** - *Computer Science Student* - [Sahar Fayez](https://github.com/saharfayez)
* **Hoda Salama** - *Computer Science Student* - [Hoda Salama]()


<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

