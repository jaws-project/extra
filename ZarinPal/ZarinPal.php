<?php
/**
 * ZarinPal gateway library
 *
 * @category    Gateway
 * @package     Gateway
 * @author      Mohsen Khahani <mkhahani@gmail.com>
 * @copyright   2013 Jaws Development Group
 * @license     http://www.gnu.org/copyleft/lesser.html
 * @version     ZarinPal.php v1.0 2013-03-15 11:00:00
 */

/**
 * Constants
 */
define('ZARINPAL_SOAP_URL', 'http://www.zarinpal.com/WebserviceGateway/wsdl');
define('ZARINPAL_PAYMENT_URL', 'https://ir.zarinpal.com/users/pay_invoice/');

/**
 * ZarinPalGateway Class
 */
class ZarinPalGateway
{

    /**
     * Merchant ID of your gateway
     *
     * @access private
     * @var    string;
     */
    var $_merchant_id;

    /**
     * SOAP connection handler
     *
     * @access private
     * @var    object;
     */
    var $_connection;

    /**
     * Class constructor
     *
     * @access  public
     * @param   string  $merchant_id    Merchant ID
     * @return  void
     */
    function ZarinPalGateway($merchant_id)
    {
        $this->_merchant_id = $merchant_id;
        $this->_connection = new SoapClient(
            ZARINPAL_SOAP_URL, 
            array('encoding'=>'UTF-8')
        );
    }

    /**
     * Sends transaction request unto ZarinPal gateway via SOAP connection
     *
     * @access  public
     * @param   int     $amount         Amount
     * @param   string  $desc           Description (max 250)
     * @param   string  $return_url     URL to redirect to
     * @return  mixed   Negative integer on error or string Transaction ID(36 chars)   
     */
    function Request($amount, $desc, $return_url)
    {
        return $this->_connection->PaymentRequest(
            $this->_merchant_id,
            $amount,
            $return_url,
            urlencode($desc)
        );
    }

    /**
     * Sends more information about transaction (optional)
     *
     * @access  public
     * @param   string  $trans_id   Transaction ID
     * @param   string  $email      Email
     * @param   string  $tel        Phone number
     * @return  void
     */
    function SendDetails($trans_id, $email, $tel)
    {
        $this->_connection->PaymentDetails(
            $this->_merchant_id,
            $trans_id,
            $email,
            $tel
        );
    }

    /**
     * Redirects to ZarinPal payment page
     *
     * @access  public
     * @param   string  $trans_id   Transaction ID
     * @return  void
     */
    function Pay($trans_id)
    {
        require_once JAWS_PATH . 'include/Jaws/Header.php';
        Jaws_Header::Location(ZARINPAL_PAYMENT_URL . $trans_id);
    }

    /**
     * Verifies transaction
     *
     * @access  public
     * @param   string  $trans_id   Transaction ID
     * @param   int     $amount     Amount
     * @return  int     Result code
     */
    function Verify($trans_id, $amount)
    {
        return $this->_connection->PaymentVerification(
            $this->_merchant_id,
            $trans_id,
            $amount
        );
    }
}