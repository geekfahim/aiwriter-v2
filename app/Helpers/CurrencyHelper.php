<?php

namespace App\Helpers;

use App\Models\Setting;
use Illuminate\Support\Facades\DB;

class CurrencyHelper
{
    /**
     * Formats number.
     *
     * @param $value
     * @return string
     */
    public static function format($value)
    {
        $code = Setting::where('key', 'currency')->first()->value;
        $formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::CURRENCY);
        return $formatter->formatCurrency($value, $code);
    }

    /**
     * Formats number without currency symbol.
     *
     * @param $value
     * @return string
     */
    public static function format_no_currency($value){
        $code = Setting::where('key', 'currency')->first()->value;
        $locale = config('app.locale');
        $formatter = new \NumberFormatter($locale, \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
        return $formatter->format($value);
    }

    /**
     * Displays currency symbol.
     *
     * @param $value
     * @return string
     */
    public static function format_currency_symbol($currency = null){
        if($currency == null){
            $currency = Setting::where('key', 'currency')->first()->value;
        }
        $locale = config('app.locale');
        $formatter = new \NumberFormatter($locale . '@currency=' . $currency, \NumberFormatter::CURRENCY);
        $symbol = $formatter->getSymbol(\NumberFormatter::CURRENCY_SYMBOL);
        return $symbol;
    }

    /**
     * Displays number with decimals.
     *
     * @param $value
     * @return string
     */
    public static function format_number($value){
        $formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
        $formatter->setAttribute(\NumberFormatter::GROUPING_USED, true);
        return $formatter->format($value);
    }

    /**
     * Displays number with currency.
     *
     * @param $value
     * @return string
     */
    public static function format_with_currency($value, $currency = null){
        $formatter = new \NumberFormatter(config('app.locale'), \NumberFormatter::DECIMAL);
        $formatter->setAttribute(\NumberFormatter::FRACTION_DIGITS, 2);
        $formatter->setAttribute(\NumberFormatter::GROUPING_USED, true);
        return CurrencyHelper::format_currency_symbol($currency).$formatter->format($value);
    }

    /**
     * Returns the discount amount.
     * Amount * Discount%
     *
     * @param $amount
     * @param $discount
     * @return float|int
     */
    public static function calculateDiscount($amount, $discount)
    {
        return $amount * ($discount / 100);
    }

    /**
     * Returns the amount after discount.
     * Amount - Discount$
     *
     * @param $amount
     * @param $discount
     * @return float|int
     */
    public static function calculatePostDiscount($amount, $discount)
    {
        return $amount - CurrencyHelper::calculateDiscount($amount, $discount);
    }

    /**
     * Returns the inclusive taxes amount.
     * PostDiscount - PostDiscount / (1 + TaxRate)
     *
     * @param $amount
     * @param $discount
     * @param $inclusiveTaxRate
     * @return float|int
     */
    public static function calculateInclusiveTaxes($amount, $discount, $inclusiveTaxRate)
    {
        return CurrencyHelper::calculatePostDiscount($amount, $discount) - (CurrencyHelper::calculatePostDiscount($amount, $discount) / (1 + ($inclusiveTaxRate / 100)));
    }

    /**
     * Returns the amount after discount and included taxes.
     * PostDiscount - InclusiveTaxes$
     *
     * @param $amount
     * @param $discount
     * @param $inclusiveTaxRates
     * @return float|int
     */
    public static function calculatePostDiscountLessInclTaxes($amount, $discount, $inclusiveTaxRates)
    {
        return CurrencyHelper::calculatePostDiscount($amount, $discount) - CurrencyHelper::calculateInclusiveTaxes($amount, $discount, $inclusiveTaxRates);
    }

    /**
     * Returns the amount of an inclusive tax.
     * PostDiscountLessInclTaxes * (Tax / 100)
     *
     * @param $amount
     * @param $discount
     * @param $inclusiveTaxRate
     * @param $inclusiveTaxRates
     * @return float|int
     */
    public static function calculateInclusiveTax($amount, $discount, $inclusiveTaxRate, $inclusiveTaxRates)
    {
        return CurrencyHelper::calculatePostDiscountLessInclTaxes($amount, $discount, $inclusiveTaxRates) * ($inclusiveTaxRate / 100);
    }

    /**
     * Returns the exclusive tax amount.
     * PostDiscountLessInclTaxes * TaxRate
     *
     * @param $amount
     * @param $discount
     * @param $exclusiveTaxRate
     * @param $inclusiveTaxRates
     * @return float|int
     */
    public static function checkoutExclusiveTax($amount, $discount, $exclusiveTaxRate, $inclusiveTaxRates)
    {
        return CurrencyHelper::calculatePostDiscountLessInclTaxes($amount, $discount, $inclusiveTaxRates) * ($exclusiveTaxRate / 100);
    }

    /**
     * Calculate the total, including the exclusive taxes.
     * PostDiscount + ExclusiveTax$
     *
     * @param $amount
     * @param $discount
     * @param $exclusiveTaxRates
     * @param $inclusiveTaxRates
     * @return float|int
     */
    public static function checkoutTotal($amount, $discount, $exclusiveTaxRates, $inclusiveTaxRates)
    {
        return CurrencyHelper::calculatePostDiscount($amount, $discount) + CurrencyHelper::checkoutExclusiveTax($amount, $discount, $exclusiveTaxRates, $inclusiveTaxRates);
    }
}