<?php declare(strict_types=1);

use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Validator\Validation;
use Chrisguitarguy\SymfonyFormOneRequired\ExampleFormType;

require __DIR__.'/vendor/autoload.php';

$formFactory = Forms::createFormFactoryBuilder()
    ->addExtension(new ValidatorExtension(Validation::createValidator()))
    ->getFormFactory();

$form = $formFactory->create(ExampleFormType::class);

$form->submit([]);
if ($form->isSubmitted() && !$form->isValid()) {
    echo 'form is not valid!', PHP_EOL;
    foreach ($form->getErrors(true) as $error) {
        echo "\tERROR: ", $error->getMessage(), PHP_EOL;
    }
}

$form = $formFactory->create(ExampleFormType::class);
$form->submit(['first' => 'yep']);
var_dump($form->isValid());
