<?php

// setting
ini_set('display_errors', '1');
error_reporting(E_ALL);


// loading everything
require_once 'vendor/autoload.php';

use FrenchFrogs\Core;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FrenchFrogz demo</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <style>
        body {
            padding-top: 50px;
        }
        .starter-template {
            padding: 40px 15px;
        }
    </style>

</head>

<body>

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">French Frogz</a>
        </div>
    </div>
</nav>

<div class="container">

    <div class="starter-template hidden">
        <h1>Form</h1>

        <?php
        /**
         *
         * Exemple de formulaire
         *
         *
         */
        $form = Core\Factory::form()->addStyle('width', '400px');
        $form->addTitle('Input');
        $form->addText('text_test', 'Text')->setPlaceholder()->addFilter('lower');
        $form->addPassword('password_test', 'Password')->setPlaceholder()->getValidator()->addRule('required');
        $form->addTel('tel', 'Telephone')->getValidator()->addRule('required');
        $form->addNumber('number', 'Un nombre')->setPlaceholder()->getValidator()->addRule('required');
        $form->addEmail('email', 'Email')->setPlaceholder('Coucouc les amis')->getValidator()->addRule('required');
        $form->addHidden('hidden');
        $form->addTextarea('textarea', 'Textarea')->getValidator()->addRule('required');
        $form->addFile('file', 'Fichier')->getValidator()->addRule('required');
        $form->addTitle('Multiple');
        $form->addCheckbox('checkbox','Checkbox')->getValidator()->addRule('required');
        $form->addCheckbox('multicheckbox','MultiCheckbox', ['titi', 'toto', 'tutu'])->getValidator()->addRule('required');
        $form->addSeparator();
        $form->addRadio('radio','Radio', ['titi', 'toto', 'tutu'])->getValidator()->addRule('required');
        $form->addSelect('select','Select', ['titi', 'toto', 'tutu'])->setPlaceholder('Le select')->getValidator()->addRule('required');
        $form->addSelect('multiselect','MultiSelect', ['titi', 'toto', 'tutu'])->enableMultiple()->getValidator()->addRule('required');
        $form->addTitle('Perso');
        $form->addLabel('label', 'Label');
        $form->addContent('Content', '<button class="btn">Button</button> Et oui ca marche');
        $form->addButton('mybutton', 'Button');
        $form->addSubmit('Enregistrer');
        $form->filter(['text_test' => 'OUOUOUOUOUOU']);

        echo $form;

        ?>
    </div>

    <div class="starter-template">
        <h1>Table</h1>

        <?php
        /**
         *
         * Exemple de formulaire
         *
         *
         */

        $col = ['col1', 'col2', 'col3', 'col4'];
        $col = array_combine($col,$col);

        $data = [];
        for($i = 0; $i < rand(10,25); $i++ ){
            $data[] = $col;
        }

        $table = Core\Factory::table($data);
        $table->addText('col1', 'Colonne 1');
        $table->addText('col2', 'Papa');
        $table->addLink('col3', 'Maman', "javascript:alert('%s')", 'col3');
        $table->addButton('col4', 'Frerot', "javascript:alert('%s')", 'col4')->icon('fa fa-amazon')->setOptionAsPrimary();



        echo $table;

        ?>
    </div>




</div><!-- /.container -->


<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script>
    $(function() {
            $('[data-toggle="tooltip"]').tooltip();
    });


</script>

</body>
</html>