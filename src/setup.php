<?php

/* Init config (équivalent .env) */
require 'config/config.php';
require 'Libs/debug/dump_r.php';

/* Classes métier */
require 'Libs/HTTP.php';
require 'Libs/Head.php';

/* Models/Entitys */
require 'Model/Model.php';

/* Router */
require 'router.php';
