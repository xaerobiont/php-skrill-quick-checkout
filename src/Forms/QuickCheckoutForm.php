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
    protected $action = 'https://pay.skrill.com';

    /**
     * HTML form target
     * @var string
     */
    protected $target = '_blank';

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
     * @param array $htmlOptions
     * @return string
     */
    public function open($htmlOptions = [])
    {
        $action = $this->action;
        if (isset($htmlOptions['action'])) {
            $action = $htmlOptions['action'];
            unset($htmlOptions['action']);
        }
        $target = $this->target;
        if (isset($htmlOptions['target'])) {
            $target = $htmlOptions['target'];
            unset($htmlOptions['target']);
        }

        $form = sprintf('<form action="%s" target="%s"', $action, $target);
        if (!empty($htmlOptions)) {
            foreach ($htmlOptions as $opName => $opValue) {
                $form .= sprintf(' %s="%s"', $opName, $opValue);
            }
        }
        $form .= '>';

        return $form;
    }

    /**
     * @param array $exclude
     * @return string
     */
    public function renderHidden($exclude = [])
    {
        $fields = $this->model->asArray();
        $html = '';
        foreach ($fields as $name => $value) {
            if (in_array($name, $exclude)) {
                continue;
            }
            $html .= sprintf('<input type="hidden" name="%s" value="%s">', $name, $value);
        }

        return $html;
    }

    /**
     * @param $text
     * @param array $htmlOptions
     * @return string
     */
    public function renderSubmit($text, $htmlOptions = [])
    {
        $submit = sprintf('<input type="submit" value="%s"', $text);
        if (!empty($htmlOptions)) {
            foreach ($htmlOptions as $opName => $opValue) {
                $submit .= sprintf(' %s="%s"', $opName, $opValue);
            }
        }
        $submit .= '>';

        return $submit;
    }

    /**
     * @return string
     */
    public function close()
    {
        return '</form>';
    }
}