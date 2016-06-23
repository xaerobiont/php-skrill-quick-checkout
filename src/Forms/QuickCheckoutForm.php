<?php

namespace zvook\Skrill\Forms;

use zvook\Skrill\Models\QuickCheckout;

/**
 * @package zvook\Skrill
 * @author Dmitry zvook Klyukin
 */
class QuickCheckoutForm
{
    /**
     * Skrill payment URL
     * @var string
     */
    protected $action = 'http://www.moneybookers.com/app/payment.pl';

    /**
     * HTML form target
     * @var string
     */
    protected $target = '_blank';

    /**
     * @var string
     */
    protected $formClass = 'skrill-payment-form';

    /**
     * Text over the submit button
     * @var string
     */
    protected $submitText = 'Pay';

    /**
     * Array of visible HTML inputs with labels
     * The name of field will be also rendered as input "class" attribute
     * Structure: ['field_name' => 'label']
     * @var array
     */
    protected $visibleFields = [];

    /**
     * @var QuickCheckout
     */
    private $model;

    /**
     * @param QuickCheckout $model
     */
    function __construct(QuickCheckout $model)
    {
        $this->model = $model;
    }

    /**
     * @param string $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @param string $target
     * @return $this
     */
    public function setTarget($target)
    {
        $this->target = $target;

        return $this;
    }

    /**
     * @param string $submitText
     * @return $this
     */
    public function setSubmitText($submitText)
    {
        $this->submitText = $submitText;

        return $this;
    }

    /**
     * @param array $visibleFields
     * @return $this
     */
    public function setVisibleFields($visibleFields)
    {
        $this->visibleFields = $visibleFields;

        return $this;
    }

    /**
     * @param mixed $formClass
     * @return $this
     */
    public function setFormClass($formClass)
    {
        $this->formClass = $formClass;

        return $this;
    }

    /**
     * Returns HTML form code
     * @return string
     */
    public function render()
    {
        $fields = $this->model->asArray();
        $form = sprintf(
            '<form action="%s" method="post" target="%s" class="%s">',
            $this->action, $this->target, $this->formClass
        );
        foreach ($fields as $name => $value) {
            if (array_key_exists($name, $this->visibleFields)) {
                $form .= sprintf('<label for="%s">%s</label>', $name, $this->visibleFields[$name]);
                $form .= sprintf(
                    '<input type="text" class="%s" id="%s" name="%s" value="%s">',
                    $name, $name, $name, $value
                );
            }
            $form .= sprintf('<input type="hidden" name="%s" value="%s">', $name, $value);
        }
        $form .= sprintf('<input type="submit" value="%s">', $this->submitText);
        $form .= '</form>';

        return $form;
    }
}