<?php

/**
 * Copyright © Lehan, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

declare(strict_types=1);

namespace Adobe\ViewModelExample\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Stdlib\DateTime;
use Magento\Framework\Url\EncoderInterface;
use Magento\Framework\Url\DecoderInterface;

/**
 * Class DeliveryMessage
 * @package Adobe\ViewModelExample\ViewModel
 */
class DeliveryMessage implements ArgumentInterface
{
    /**
     * @var DateTime
     */
    private DateTime $dateTime;
    /**
     * @var EncoderInterface
     */
    private EncoderInterface $encoder;
    /**
     * @var DecoderInterface
     */
    private DecoderInterface $decoder;

    /**
     * DeliveryMessage constructor.
     * @param DateTime $dateTime
     * @param EncoderInterface $encoder
     * @param DecoderInterface $decoder
     */
    public function __construct(DateTime $dateTime, EncoderInterface $encoder, DecoderInterface $decoder)
    {
        $this->dateTime = $dateTime;
        $this->encoder = $encoder;
        $this->decoder = $decoder;
    }

    /**
     * display current date to internal format time zone
     * @return string
     */
    public function getMessage(): string
    {
        $encodeUrl = $this->encoder->encode('http://magento2.docker/customer/account/login');
        return 'Lorem ipsum dolor sit amet........ ' . ' ' . $this->dateTime->formatDate(time()) . ' ' . $encodeUrl . ' ' . $this->decoder->decode($encodeUrl);
    }
}
