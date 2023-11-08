<?php

/* Init config (équivalent .env) */
require 'config/config.php';
require 'Libs/debug/dump_r.php';

/* Classes métier */
require 'Libs/HTTP.php';
require 'Libs/Head.php';

/* Models/Entitys */
require 'Model/Model.php';
require 'Model/AdministrateurModel.php';
require 'Model/ContributionModel.php';
require 'Model/JoueurModel.php';
require 'Model/LoufokerieModel.php';
require 'Model/RandomModel.php';

/* Controllers */
require 'Controller/AdminController.php';
require 'Controller/ApiController.php';
require 'Controller/AuthController.php';
require 'Controller/ErrorController.php';
require 'Controller/UserController.php';

/* Views */
require 'View/loginPage.php';

/* Router */
require 'router.php';
