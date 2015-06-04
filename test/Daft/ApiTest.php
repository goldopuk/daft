<?
/**
 * This example will produce a list of the counties in Ireland.
 */

$DaftAPI = new SoapClient("http://api.daft.ie/v2/wsdl.xml");

$parameters = array(
    'api_key'       =>  "5fac8f1674c0c6a335ecefe2b092c05d02a2b6e5"
    , 'area_type'   =>  "county"
);

$response = $DaftAPI->areas($parameters);

foreach($response->areas as $county)
{
    print "'" . substr($county->name, 4) . "', ";
}