<?php
class ComWxparamsControllerToolbarCommandSettings extends KControllerToolbarCommandDefault
{

    public function __construct($config = array())
    {
        $config->append(array(
            'config_package' => KRequest::get('get.option', 'cmd') , 
            'config_type' => 'view.' . KInflector::singularize(KRequest::get('get.view', 'cmd'))
        ))->append(array(
            
            'attribs' => array(
                
                'href' => 'index.php?option=com_wxparams&view=configurations&package=' . $config->config_package . '&type=' . $config->config_type , 
                'onclick' => 'wxjq(this).colorbox({width: \'95%\', height: \'95%\', iframe: true}); return false;'
            )
        ));
        parent::__construct($config);
        $document = KFactory::get('lib.joomla.document');
        $document->addStyleSheet(WxHelperUri::absolutize('media/com_wxparams/css/admin.css'));
    }
}