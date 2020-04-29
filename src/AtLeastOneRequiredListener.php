<?php declare(strict_types=1);

namespace Chrisguitarguy\SymfonyFormOneRequired;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class AtLeastOneRequiredListener implements EventSubscriberInterface
{
    /**
     * @var string[]
     */
    private $fieldsToCheck;

    public function __construct(string $firstFieldToCheck, string $secondFieldToCheck, string ...$additionalFieldsToCheck)
    {
        $this->fieldsToCheck = [$firstFieldToCheck, $secondFieldToCheck] + $additionalFieldsToCheck;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::SUBMIT => 'onSubmit',
        ];
    }

    public function onSubmit(FormEvent $event)
    {
        $submittedData = $event->getData();

        $emptyFields = [];
        foreach ($this->fieldsToCheck as $fieldToCheck) {
            if (!isset($submittedData[$fieldToCheck])) {
                $emptyFields[] = $fieldToCheck;
            }
        }

        if (count($emptyFields) === count($this->fieldsToCheck)) {
            throw new TransformationFailedException(sprintf(
                'at least one of %s is required',
                implode(', ', $this->fieldsToCheck)
            ));
        }
    }
}
