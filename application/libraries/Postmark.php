<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Postmark Email Library
 *
 * Permits email to be sent using Postmarkapp.com's Servers
 *
 * @category	Libraries
 * @author      Based on work by János Rusiczki & Markus Hedlund’s.
 * @modified    Heavily Modified by Zack Kitzmiller
 * @link        http://www.github.com/zackkitzmiller/postmark-codeigniter
*/

class Postmark {

    //private
    private $CI;
    private $api_key = '';
    private $validation = false;
    private $strip_html = false;
    private $develop = false;
    
    private $from_name;
    private $from_address;
    
    private $_reply_to_name;
    private $_reply_to_address;
    
    private $_to_name;
    private $_to_address;
    
    private $_cc_name;
    private $_cc_address;
    
    private $_subject;
    private $_message_plain;
    private $_message_html;

    private $_tag;
    
    private $_attachments = array();
    
    /**
     * Constructor
     *
     * @access	public
     * @param	array	initialization parameters
     */	
    public function __construct($params = array())
    {
        $this->CI =& get_instance();
        
        if (count($params) > 0)
        {
            $this->initialize($params);
        }
    	
    	if ($this->develop == true)
    	{
    	   $this->api_key = 'POSTMARK_API_TEST';
    	}
    	
        log_message('debug', 'Postmark Class Initialized');
    
    }

	// --------------------------------------------------------------------

	/**
	 * Initialize Preferences
	 *
	 * @access	public
	 * @param	array	initialization parameters
	 * @return	void
	 */	
    public function initialize($params)
	{
        $this->clear();
		if (count($params) > 0)
        {
            foreach ($params as $key => $value)
            {
                if (isset($this->$key))
                {
                    $this->$key = $value;
                }
            }
        }
	}

	// --------------------------------------------------------------------

	/**
	 * Clear the Email Data
	 *
	 * @access	public
	 * @return	void
	 */	
    public function clear()
	{
        $this->from_name = '';
    	$this->from_address = '';
    	
    	$this->_to_name = '';
    	$this->_to_address = '';
    	
    	$this->_cc_name = '';
    	$this->_cc_address = '';
    	
    	$this->_subject = '';
    	$this->_message_plain = '';
    	$this->_message_html = '';
    	
    	$this->_tag = '';
    	
    	$this->_attachments = array();
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Email FROM address
	 *
	 * This could also be set in the config file
	 *
	 * TODO:
	 * Validate Email Addresses ala CodeIgniter's Email Class
	 *
	 * @access	public
	 * @return	void
	 */	
	public function from($address, $name = null)
	{
		
		if ( ! $this->validation == true)
		{
            $this->from_address = $address;
            $this->from_name = $name;
		} 
		else
        {
            if ($this->_validate_email($address))
            {
                $this->from_address = $address;
                $this->from_name = $name;
            }
            else
            {
                show_error('You have entered an invalid sender address.');
            }
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Email TO address
	 *
	 * TODO:
	 * Validate Email Addresses ala CodeIgniter's Email Class
	 *
	 * @access	public
	 * @return	void
	 */	
	public function to($address, $name = null)
	{
	        
		if ( ! $this->validation == true)
		{
            $this->_to_address = $address;
            $this->_to_name = $name;
		} 
		else
        {
            if ($this->_validate_email($address))
            {
                $this->_to_address = $address;
                $this->_to_name = $name;
            }
            else
            {
                show_error('You have entered an invalid recipient address.');
            }
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Email ReplyTo address
	 *
	 * TODO:
	 * Validate Email Addresses ala CodeIgniter's Email Class
	 *
	 * @access	public
	 * @return	void
	 */	
	public function reply_to($address, $name = null)
	{
		if ( ! $this->validation == true)
		{
            $this->_reply_to_address = $address;
            $this->_reply_to_name = $name;
		} 
		else
        {
            if ($this->_validate_email($address))
            {
                $this->_reply_to_address = $address;
                $this->_reply_to_name = $name;
            }
            else
            {
                show_error('You have entered an invalid reply to address.');
            }
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Set Email CC address
	 *
	 * TODO:
	 * Validate Email Addresses ala CodeIgniter's Email Class
	 *
	 * @access	public
	 * @return	void
	 */	
	public function cc($address, $name = null)
	{
	        
		if ( ! $this->validation == true)
		{
            $this->_cc_address = $address;
            $this->_cc_name = $name;
		} 
		else
        {
            if ($this->_validate_email($address))
            {
                $this->_cc_address = $address;
                $this->_cc_name = $name;
            }
            else
            {
                show_error('You have entered an invalid recipient address.');
            }
		}
	}
		
	// --------------------------------------------------------------------

	/**
	 * Set Email Subject
	 *
	 * @access	public
	 * @return	void
	 */	
	public function subject($subject)
	{
		$this->_subject = $subject;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Set Tag
	 *
	 * @access	public
	 * @return	void
	 */	
	public function tag($tag)
	{
		$this->_tag = $tag;
	}	
	
	// --------------------------------------------------------------------

	/**
	 * Set Email Message in Plain Text
	 *
	 * @access	public
	 * @return	void
	 */	
	public function message_plain($message)
	{
		if ( ! $this->strip_html )
		{
		  $this->_message_plain = $message;
		}
		else
		{
		  $this->_message_plain = $this->_strip_html($message);
		}
	}  

	// --------------------------------------------------------------------

	/**
	 * Set Email Message in HTML
	 *
	 * @access	public
	 * @return	void
	 */	
	public function message_html($message)
	{
		$this->_message_html = $message;
	}
	
	// --------------------------------------------------------------------

	/**
	 * Add an attachment
	 *
	 * @access	public
	 * @return	bool
	 * @author  Adam Jackett
	 */	
	public function attach($file, $filename = false)
	{
		$filesize = filesize($file) + 1;
		if ( ! $fp = fopen($file, FOPEN_READ))
		{
			return false;
		}
		
		$content = chunk_split(base64_encode(fread($fp, $filesize)));
		fclose($fp);
		
		if(!$filename) $filename = end(explode('/', $file));
		
		$this->_attachments[] = array(
			'Name' => $filename,
			'Content' => $content,
			'ContentType' => $this->_mime_types(end(explode('.', basename($filename))))
		);
		
		return true;
	}
	
	// --------------------------------------------------------------------
    /**
    * Private Function to prepare and send email
	* 
	* @access private
	* @return mixed
    */
	private function _prepare_data()
	{
        $data = array();
		$data['Subject'] = $this->_subject;
        		
		$data['From'] = is_null($this->from_name) ? $this->from_address : "{$this->from_name} <{$this->from_address}>";
		$data['To'] = is_null($this->_to_name) ? $this->_to_address : "{$this->_to_name} <{$this->_to_address}>";
		
		if (!is_null($this->_cc_address) && ($this->_cc_address != '')) {
            $data['Cc'] = is_null($this->_cc_name) ? $this->_cc_address : "{$this->_cc_name} <{$this->_cc_address}>";
		}

		if (!is_null($this->_reply_to_address) && ($this->_reply_to_address != ''))
		{
            $data['ReplyTo'] = is_null($this->_reply_to_name) ? $this->_reply_to_address : "{$this->_reply_to_name} <{$this->_reply_to_address}>";
		}
		
		if (!is_null($this->_tag) && ($this->_tag != ''))
		{
		  $data['tag'] = $this->_tag;
		}
		
		if (!is_null($this->_message_html))
		{
			$data['HtmlBody'] = $this->_message_html;
		}
		
		if (!is_null($this->_message_plain))
		{
			$data['TextBody'] = $this->_message_plain;
		}
		
		if(count($this->_attachments) > 0)
		{
			$data['Attachments'] = $this->_attachments;
		}
		
		return $data;
	}
	
    public function send()
	{
        if (!function_exists('curl_init'))
        {
            if(function_exists('log_message'))
            {
                log_message('error', 'Postmark - PHP was not built with cURL enabled. Rebuild PHP with --with-curl to use cURL.');            
            }
            
            return false;                
        }
	
		if (is_null($this->api_key))
		{
			show_error("Postmark API key is not set!");
		}
		
		if (is_null($this->from_address))
		{
			show_error("From address is not set!");
		}
		
		if (is_null($this->_to_address)) 
		{
			show_error("To address is not set!");
		}
		
		if (is_null($this->_subject))
		{
			show_error("Subject is not set!");
		}
		
		if (is_null($this->_message_plain) && is_null($this->_message_html))
		{
			show_error("Please either set plain message, HTML message or both!");
		}
	
		$encoded_data = json_encode($this->_prepare_data());
		
		$headers = array(
			'Accept: application/json',
			'Content-Type: application/json',
			'X-Postmark-Server-Token: ' . $this->api_key
		);
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.postmarkapp.com/email');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded_data);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		
		$return = curl_exec($ch);
		log_message('debug', 'POSTMARK JSON: ' . $encoded_data . "\nHeaders: \n\t" . implode("\n\t", $headers) . "\nReturn:\n$return");
		
		if (curl_error($ch) != '')
		{
			show_error(curl_error($ch));
		}
		
		$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
		log_message('debug', 'POSTMARK http code:' . $httpCode);
		
		if (intval($httpCode / 100) != 2)
		{
			$message = json_decode($return)->Message;
			show_error('Error while mailing. Postmark returned HTTP code ' . $httpCode . ' with message "'.$message.'"');
		}
	}
	
	// --------------------------------------------------------------------

	/**
	 * Email Validation
	 *
	 * @access	private
	 * @param	string
	 * @return	bool
	 */
	private function _validate_email($address)
	{
		$addresses = explode(',', $address);
				
		foreach($addresses as $k => $v) {
            if ( ! preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", trim($v)))
			{
                return false;
            }
		}
		
        return true;
	}

	// --------------------------------------------------------------------

	/**
	 * Strip Html
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */	
	private function _strip_html($message)
	{
        $message =  preg_replace('/\<br(\s*)?\/?\>/i', "\n", $message);
        return strip_tags($message);
	}	
	
	// --------------------------------------------------------------------

	/**
	 * Mime Types
	 *
	 * @access	private
	 * @param	string
	 * @return	string
	 */
	private function _mime_types($ext = "")
	{
		$mimes = array(	'hqx'	=>	'application/mac-binhex40',
						'cpt'	=>	'application/mac-compactpro',
						'doc'	=>	'application/msword',
						'bin'	=>	'application/macbinary',
						'dms'	=>	'application/octet-stream',
						'lha'	=>	'application/octet-stream',
						'lzh'	=>	'application/octet-stream',
						'exe'	=>	'application/octet-stream',
						'class'	=>	'application/octet-stream',
						'psd'	=>	'application/octet-stream',
						'so'	=>	'application/octet-stream',
						'sea'	=>	'application/octet-stream',
						'dll'	=>	'application/octet-stream',
						'oda'	=>	'application/oda',
						'pdf'	=>	'application/pdf',
						'ai'	=>	'application/postscript',
						'eps'	=>	'application/postscript',
						'ps'	=>	'application/postscript',
						'smi'	=>	'application/smil',
						'smil'	=>	'application/smil',
						'mif'	=>	'application/vnd.mif',
						'xls'	=>	'application/vnd.ms-excel',
						'ppt'	=>	'application/vnd.ms-powerpoint',
						'wbxml'	=>	'application/vnd.wap.wbxml',
						'wmlc'	=>	'application/vnd.wap.wmlc',
						'dcr'	=>	'application/x-director',
						'dir'	=>	'application/x-director',
						'dxr'	=>	'application/x-director',
						'dvi'	=>	'application/x-dvi',
						'gtar'	=>	'application/x-gtar',
						'php'	=>	'application/x-httpd-php',
						'php4'	=>	'application/x-httpd-php',
						'php3'	=>	'application/x-httpd-php',
						'phtml'	=>	'application/x-httpd-php',
						'phps'	=>	'application/x-httpd-php-source',
						'js'	=>	'application/x-javascript',
						'swf'	=>	'application/x-shockwave-flash',
						'sit'	=>	'application/x-stuffit',
						'tar'	=>	'application/x-tar',
						'tgz'	=>	'application/x-tar',
						'xhtml'	=>	'application/xhtml+xml',
						'xht'	=>	'application/xhtml+xml',
						'zip'	=>	'application/zip',
						'mid'	=>	'audio/midi',
						'midi'	=>	'audio/midi',
						'mpga'	=>	'audio/mpeg',
						'mp2'	=>	'audio/mpeg',
						'mp3'	=>	'audio/mpeg',
						'aif'	=>	'audio/x-aiff',
						'aiff'	=>	'audio/x-aiff',
						'aifc'	=>	'audio/x-aiff',
						'ram'	=>	'audio/x-pn-realaudio',
						'rm'	=>	'audio/x-pn-realaudio',
						'rpm'	=>	'audio/x-pn-realaudio-plugin',
						'ra'	=>	'audio/x-realaudio',
						'rv'	=>	'video/vnd.rn-realvideo',
						'wav'	=>	'audio/x-wav',
						'bmp'	=>	'image/bmp',
						'gif'	=>	'image/gif',
						'jpeg'	=>	'image/jpeg',
						'jpg'	=>	'image/jpeg',
						'jpe'	=>	'image/jpeg',
						'png'	=>	'image/png',
						'tiff'	=>	'image/tiff',
						'tif'	=>	'image/tiff',
						'css'	=>	'text/css',
						'html'	=>	'text/html',
						'htm'	=>	'text/html',
						'shtml'	=>	'text/html',
						'txt'	=>	'text/plain',
						'text'	=>	'text/plain',
						'log'	=>	'text/plain',
						'rtx'	=>	'text/richtext',
						'rtf'	=>	'text/rtf',
						'xml'	=>	'text/xml',
						'xsl'	=>	'text/xml',
						'mpeg'	=>	'video/mpeg',
						'mpg'	=>	'video/mpeg',
						'mpe'	=>	'video/mpeg',
						'qt'	=>	'video/quicktime',
						'mov'	=>	'video/quicktime',
						'avi'	=>	'video/x-msvideo',
						'movie'	=>	'video/x-sgi-movie',
						'doc'	=>	'application/msword',
						'word'	=>	'application/msword',
						'xl'	=>	'application/excel',
						'eml'	=>	'message/rfc822'
					);

		return ( ! isset($mimes[strtolower($ext)])) ? "application/x-unknown-content-type" : $mimes[strtolower($ext)];
	}
}