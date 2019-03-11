<?php


defined('BASEPATH') OR exit('No direct script access allowed');

class Facturacion {

    // Se desactivan los mensajes de debug
    /*error_reporting(~(E_WARNING|E_NOTICE));*/
    //error_reporting(E_ALL);

    // Se especifica la zona horaria
    public function facturar($order,$receptor,$comprobante)
    {
        // Do something with $params
        date_default_timezone_set('America/Mexico_City');
        require_once 'sdk2.php';

        // Se especifica la version de CFDi 3.3
        $datos['version_cfdi'] = '3.3';

        // Ruta del XML Timbrado
        $datos['cfdi']=FCPATH.'assets/timbrados/'.$order['order']->order_id.'.xml';

        // Ruta del XML de Debug
        $datos['xml_debug']=FCPATH.'assets/timbrados/'.$order['order']->order_id.'.xml';

        $urlQr = FCPATH.'assets/timbrados/'.$order['order']->order_id.'.png';
        //$urlQr = $order['order']->order_id.'.png';

        /*echo base_url('assets/timbrados/'.$order['order']->order_id.'.png');
        die();*/



        // Credenciales de Timbrado
        $datos['PAC']['usuario'] = 'DEMO700101XXX';
        $datos['PAC']['pass'] = 'DEMO700101XXX';
        $datos['PAC']['produccion'] = 'NO';

        // Rutas y clave de los CSD
        $datos['conf']['cer'] = FCPATH.'application/libraries/facturacion/certificados/CSD_tvz_TVZ130830KU0_20170929_122437s.cer.pem';
        $datos['conf']['key'] = FCPATH.'application/libraries/facturacion/certificados/CSD_tvz_TVZ130830KU0_20170929_122437.key.pem';
        $datos['conf']['pass'] = 'Alyd0104';

        // Para pruebas utilizar las credenciales de default
        /*$datos['conf']['cer'] = FCPATH.'application/libraries/facturacion/certificados_default/lan7008173r5.cer.pem';
        $datos['conf']['key'] = FCPATH.'application/libraries/facturacion/certificados_default/lan7008173r5.key.pem';
        $datos['conf']['pass'] = '12345678a';*/

        // Datos de la Factura
        /*$datos['factura']['condicionesDePago'] = 'CONDICIONES';
        $datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
        $datos['factura']['folio'] = '100';
        $datos['factura']['forma_pago'] = '01';
        $datos['factura']['LugarExpedicion'] = '45079';
        $datos['factura']['metodo_pago'] = 'PUE';
        $datos['factura']['moneda'] = 'MXN';
        $datos['factura']['serie'] = 'A';
        $datos['factura']['subtotal'] = '100.00';
        $datos['factura']['tipocambio'] = '1';
        $datos['factura']['tipocomprobante'] = 'I';
        $datos['factura']['total'] = '100.00';
        $datos['factura']['RegimenFiscal'] = '601';*/

        // Para prueba utilizar el rfc de prueba
        /*$datos['emisor']['rfc'] = 'LAN7008173R5'; //RFC DE PRUEBA
        $datos['emisor']['nombre'] = 'ACCEM SERVICIOS EMPRESARIALES SC';  // EMPRESA DE PRUEBA*/

        $datos['emisor']['rfc'] = 'TVZ130830KU0'; //RFC DE PRUEBA
        $datos['emisor']['nombre'] = 'DISTRIBUIDORA DE PERFUMERIA Y POPULARES S.A DE C.V';  // EMPRESA DE PRUEBA



        // Datos del Receptor
        /*$datos['receptor']['rfc'] = 'XAXX010101000';
        $datos['receptor']['nombre'] = 'Publico en General';
        $datos['receptor']['UsoCFDI'] = 'G01';*/

        // Se agregan los conceptos
        /*for ($i = 1; $i <= 1; $i++)
        {
            $datos['conceptos'][$i]['cantidad'] = '1.00';
            $datos['conceptos'][$i]['unidad'] = 'PZ';
            $datos['conceptos'][$i]['ID'] = "COD$i";
            $datos['conceptos'][$i]['descripcion'] = "PRODUCTO $i ñ Ñ á é í ó ú &";
            $datos['conceptos'][$i]['valorunitario'] = '100.00';
            $datos['conceptos'][$i]['importe'] = '100.00';
            $datos['conceptos'][$i]['ClaveProdServ'] = '01010101';
            $datos['conceptos'][$i]['ClaveUnidad'] = 'C81';
        }

        // Se ejecuta el SDK
        $res = mf_genera_cfdi($datos);

        ///////////    MOSTRAR RESULTADOS DEL ARRAY $res   ///////////

        echo "<h1>Respuesta Generar XML y Timbrado</h1>";
        foreach($res AS $variable=>$valor)
        {
            $valor=htmlentities($valor, ENT_IGNORE);
            $valor=str_replace('&lt;br/&gt;','<br/>',$valor);
            echo "<b>[$variable]=</b>$valor<hr>";
        }

        die();*/


        // Datos de la Factura
        $datos['factura']['condicionesDePago'] = '';
        $datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
        $datos['factura']['folio'] = '000001';
        $datos['factura']['forma_pago'] = $comprobante['formaPago'];
        $datos['factura']['LugarExpedicion'] = $order['order']->zip;
        $datos['factura']['metodo_pago'] = $comprobante['metodoPago'];
        $datos['factura']['moneda'] = 'MXN';
        $datos['factura']['serie'] = 'EC';
        $datos['factura']['subtotal'] = round($order['order']->total_amount - $order['order']->tax_amount,2);
        $datos['factura']['tipocambio'] = '1';
        $datos['factura']['tipocomprobante'] = 'I';
        $datos['factura']['total'] = $order['order']->total_amount;
        $datos['factura']['RegimenFiscal'] = '601';


        // Datos del Emisor
        $datos['emisor']['rfc'] = 'TVZ130830KU0'; //RFC DE PRUEBA
        $datos['emisor']['nombre'] = 'DISTRIBUIDORA DE PERFUMERIA Y POPULARES S.A DE C.V';  // EMPRESA DE PRUEBA

        // Datos del Receptor
        $datos['receptor']['rfc'] = $receptor['rfcReceptor'];
        $datos['receptor']['nombre'] = $receptor['nombreReceptor'];
        $datos['receptor']['UsoCFDI'] = $receptor['rfcFacUso'];



        // Se agregan los conceptos
        $order_details = $order['order_details'];
        $i = 0;
        $j = 0;

        foreach($order_details as $o)
        {
            $datos['conceptos'][$i]['cantidad'] = $o['quantity'];
            $datos['conceptos'][$i]['unidad'] = $o['unit_name'];
            $datos['conceptos'][$i]['ID'] = $o['category_clave'];
            $datos['conceptos'][$i]['descripcion'] = $o['product_name'];
            $datos['conceptos'][$i]['valorunitario'] = $o['rate']-$o['discount'];
            $datos['conceptos'][$i]['ClaveProdServ'] = '01010101';
            $datos['conceptos'][$i]['ClaveUnidad'] = 'ACT';

            if($o['amount'])
            {
                $datos['conceptos'][$i]['importe'] = round(($o['total_price']-($o['quantity']*$o['discount']))-$o['amount'],2);

                $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Base'] = round(($o['total_price']-($o['quantity']*$o['discount']))-$o['amount'],2);
                $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
                $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
                $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
                $datos['conceptos'][$i]['Impuestos']['Traslados'][0]['Importe'] = round($o['amount'],2);

            }
            else
            {
                $datos['conceptos'][$i]['importe'] = $o['total_price']-($o['quantity']*$o['discount']);
            }

            $i = $i+1;
        }

        if($order['order']->tax_amount)
        {
            $datos['impuestos']['translados'][0]['impuesto'] = '002';
            $datos['impuestos']['translados'][0]['tasa'] = '0.160000';
            $datos['impuestos']['translados'][0]['importe'] = round($order['order']->tax_amount,2);
            $datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';

            $datos['impuestos']['TotalImpuestosTrasladados'] = round($order['order']->tax_amount,2);
        }

        // Se ejecuta el SDK

        /*$datos['order_details'] = $order_details;*/

        $res = mf_genera_cfdi($datos);

        /*echo "<h1>Respuesta Generar XML y Timbrado</h1>";
        foreach ($res AS $variable => $valor) {
            $valor = htmlentities($valor);
            $valor = str_replace('&lt;br/&gt;', '<br/>', $valor);
            echo "<b>[$variable]=</b>$valor<hr>";
        }

		die();*/

        if(array_key_exists('cfdi', $res))
        {
            $datosHTML['RESPUESTA_UTF8'] = "SI";
            $datosHTML['PAC']['usuario'] = "DEMO700101XXX";
            $datosHTML['PAC']['pass'] = "DEMO700101XXX";
            $datosHTML['PAC']['produccion'] = "NO";
            //MODULO MULTIFACTURAS : CONVIERTE UN XML CFDI A HTML
            $datosHTML['modulo']="cfdi2html";                                                //NOMBRE MODULO
            $datosHTML['rutaxml']=FCPATH.'assets/timbrados/'.$order['order']->order_id.'.xml';   //RUTA DEL XML CFDI
            $datosHTML['titulo']="";                                          //TITULO DE FACTURA
            $datosHTML['tipo']="FACTURA";                                                    //TIPO DE FACTURA VENTA,NOMINA,ARRENDAMIENTO, ETC
            $datosHTML['path_logo']=FCPATH.'application/libraries/facturacion/timbrados/logo.jpg';                          //RUTA DE LOGOTIPO DE FACTURA
            $datosHTML['notas']="";                                       //NOTA IMPRESA EN FACTURA
            $datosHTML['color_marco']="#013ADF";                                             //COLOR DEL MARCO DE LA FACTURA
            $datosHTML['color_marco_texto']="#FFFFFF";                                       //COLOR DEL TEXTO DEL MARCO DE LA FACTURA
            $datosHTML['color_texto']="#0174DF";                                             //COLOR DEL TEXTO EN GENERAL
            $datosHTML['fuente_texto']="monospace";                                          //FUENTE DEL TEXTO EN GENERAL

            $res = mf_ejecuta_modulo($datosHTML);                                  //FUNCION QUE CARGA EL MODULO cfdi2html
            $HTML=$res['html'];                                     //HTML DEL XML           //RESPUESTA DE LA FUNCION CARGAR MODULO
            $html1 = $this->imprime_html($datosHTML['rutaxml'],$order,$receptor,$order_details,$urlQr);
            /*echo $html1;
            die();*/



            //CONVERTIR EL HTML DEL XML CFDI A PDF
            $datosPDF['PAC']['usuario'] = "DEMO700101XXX";
            $datosPDF['PAC']['pass'] = "DEMO700101XXX";
            $datosPDF['PAC']['produccion'] = "NO";
            $datosPDF['modulo']="html2pdf";                                                   //NOMBRE MODULO
            $datosPDF['html']="$html1";                                                        // HTML DE XML CFDI A CONVERTIR A PDF
            $datosPDF['archivo_html']="";                                                     // OPCION SI SE TIENE UN ARCHIVO .HTML
            $datosPDF['archivo_pdf']=FCPATH.'assets/timbrados/'.$order['order']->order_id.'.pdf';

            $res = mf_ejecuta_modulo($datosPDF);

            /*echo $html1;
            die();*/

            return true;
        }
        else
        {
            return false;
        }

    }

    public function imprime_html($xml_archivo,$order,$receptor,$order_details,$urlQr)
    {
        $html;

        if(file_exists($xml_archivo)==false)
        {
            return 'ERROR 1, NO EXISTE XML, MUY  POSIBLEMENTE ES UNA PRUEBA FALLIDA';
        }
        if(filesize($xml_archivo)<100)
        {
            return 'ERROR 2, XML INVALIDO';
        }

        $xml = simplexml_load_file($xml_archivo);
        $ns = $xml->getNamespaces(true);
        foreach($ns as $prefijo => $uri)
        {
            $xml->registerXPathNamespace($prefijo, $uri);
        }

        foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante)
        {
            $cambio= $cfdiComprobante['TipoCambio'];

            $certificado_no=$cfdiComprobante['NoCertificado'];
            $fecha_expedicion= $cfdiComprobante['Fecha'];
            $folio=$cfdiComprobante['Folio'];
            $LugarExpedicion=autoformato_impresion($cfdiComprobante['LugarExpedicion']);

            $forma_pago=autoformato_impresion( $cfdiComprobante['FormaPago']);
            $forma_pago = formato_forma_pago33($forma_pago);

            $metodo_pago= autoformato_impresion($cfdiComprobante['MetodoPago']);
            $metodo_pago=formato_metodo_pago33($metodo_pago);

            $subtotal=$cfdiComprobante['SubTotal'];
            $subtotal_=number_format((string)$subtotal,2);

            $total=$cfdiComprobante['Total'];
            $total_=number_format((string)$total,2);

            $numeroletras=num2letras($total,'  ');

            $longitud=70;

            foreach ($xml->xpath('//tfd:TimbreFiscalDigital') as $tfd)
            {
                $timbre_selloCFD= $tfd['SelloCFD'];
                $timbre_selloCFD= wordwrap($timbre_selloCFD,$longitud,'<br>',true);
                $timbre_fecha= $tfd['FechaTimbrado'];
                $timbre_uuid= $uuid=$tfd['UUID'];
                $timbre_noCertificadoSAT= $tfd['NoCertificadoSAT'];
                $timbre_version= $tfd['Version'];
                $timbre_selloSAT = $sellosat=$tfd['SelloSAT'];
                $timbre_selloSAT = wordwrap($timbre_selloSAT,$longitud,'<br>',true);
            }

            $cadena_sat='||'.$timbre_version.'|'.$timbre_uuid.'|.'.$timbre_fecha.'|'.$timbre_selloCFD.'|'.$timbre_noCertificadoSAT.'||';
            $cadena_sat = wordwrap($cadena_sat,$longitud,'<br>',true);

            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor)
            {
                $receptor_rfc=$Receptor['Rfc'];
                $receptor_nombre=autoformato_impresion($Receptor['Nombre']);
                $uso_CFDi=$Receptor['UsoCFDI'];

            }

            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor)
            {
                $emisor_rfc=$Emisor['Rfc'];
                $emisor_nombre= autoformato_impresion($Emisor['Nombre']);
                $regimen_fiscal=$Emisor['RegimenFiscal'];
            }
        }

        $html.='<div style="width:724px; margin:0 auto;">';
        $html.='<table style="width: 100%; height: 100px;">';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td style="width: 10%;"><img src="assets/website/maqueta/images/logo-dipepsa.png" /></td>';
        $html .= '<td style="width: 60%; text-align: center;">';
        $html .= '<h3 style="font-size:11pt;">DISTRIBUIDORA DE PERFUMERIA Y POPULARES<br />S.A. DE C.V</h3>';
        $html .= '<p style="font-size:11pt;">DPP8607174L9</p>';
        $html .= '<span style="font-size:11pt;">PERSONAS MORALES REGIMEN GENERAL DE LEY&nbsp;CAR. COATZACOALCOS A BARRILLAS&nbsp;REDIO SAN JOAQUIN KM';
        $html .= '1+300&nbsp;COATZACOALCOS VER</span></td>';
        $html .= '<td style="width: 40%; text-align: center;">';
        $html .= '<table style="width: 100%; float: left;" border="1" cellspacing="0"><caption>&nbsp;</caption>';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td>';
        $html .= '<h2><strong><span style="color: #ff0000;font-size:8pt">FACTURA</span></strong></h2>';
        $html .= '<td style="font-size:8pt"></td>';
        $html .= '</td>';
        /*$html .= '<td style="width: 181.6px;">&nbsp;</td>';*/
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width:40%;font-size:7pt">FOLIO FISCAL:</td>';
        $html .= '<td style="width:60%;font-size:7pt">'.$timbre_uuid.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width:40%;font-size:7pt">CERTIFICADO :</td>';
        $html .= '<td style="width:60%;font-size:7pt">'.$certificado_no.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width:40%;font-size:7pt">CERTIFICADO SAT :</td>';
        $html .= '<td style="width:60%;font-size:7pt">'.$timbre_noCertificadoSAT.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width:40%;font-size:7pt">FECHA DE EXP. :</td>';
        $html .= '<td style="width:60%;font-size:7pt">'.$fecha_expedicion.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="width:40%;font-size:7pt">FOLIO:</td>';
        $html .= '<td style="width:60%;font-size:7pt">'.$folio.'</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</td>';
        $html .= '</tbody>';
        $html .= '</table>';


        $html .= '<table style="width: 100%; font-size:7pt;margin-top: 45px" border="1" cellspacing="0">';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td scope="col">EXPEDIDO EN<br />'.$order['order']->store_name.'<br/>';
        $html .= $order['order']->store_address.'<br/>';
        $html .= 'LUGAR Y FEC. DE EXPEDICION: '.$LugarExpedicion.' '.$fecha_expedicion.'</br>';
        $html .= 'RFC EMISOR	: '.$emisor_rfc.'</td>';
        $html .= '<td>FACTURAR A: '.$receptor['nombreReceptor'].'</br> RFC RECEPTOR:     '.$receptor_rfc.'</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</table>';

        $html .= '<table style="margin-top:5px;font-size:7pt" border="1" width="100%" cellspacing="0" cellpadding="0">';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td style="text-align: center"><strong>CONDICIONES COMERCIALES</strong></td>';
        $html .= '<td style="text-align: center"><strong>FORMA DE PAGO</strong></td>';
        $html .= '<td style="text-align: center"><strong>METODO DE PAGO</strong></td>';
        $html .= '<td style="text-align: center"><strong>USO CFDI</strong></td>';
        $html .= '<td style="text-align: center"><strong>FECHA Y HORA DE EMISION</strong></td>';
        $html .= '<td style="text-align: center"><strong>MONEDA</strong></td>';
        $html .= '<td style="text-align: center"><strong>CAMBIO</strong></td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="text-align: center">CONTADO</td>';
        $html .= '<td style="text-align: center">'.$forma_pago.'</td>';
        $html .= '<td style="text-align: center">'.$metodo_pago.'</td>';
        $html .= '<td style="text-align: center">'.$uso_CFDi.'</td>';
        $html .= '<td style="text-align: center">'.$fecha_expedicion.'</td>';
        $html .= '<td style="text-align: center">MXN PESOS MEXICANOS</td>';
        $html .= '<td style="text-align: center">'.$cambio.'</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';


        $html .= '<table style="font-size:7pt;margin-top:5px float: left;" border="1" width="100%" cellspacing="0">';
        $html .= '<thead>';
        $html .= '<tr style="text-align: center;">';
        $html .= '<td style="width: 8%;"><strong>CLAVE SAT</strong></td>';
        $html .= '<td style="width: 7%"><strong>CANTIDAD</strong></td>';
        $html .= '<td style="width: 6%"><strong>UNIDAD</strong></td>';
        $html .= '<td style="width: 20%;"><strong>DESCRIPCION</strong></td>';
        $html .= '<td style="width: 10%;"><strong>PRECIO UNITARIO</strong></td>';
        $html .= '<td style="width: 8%;"><strong>% IVA TASA</strong></td>';
        $html .= '<td style="width: 10%;"><strong>IVA </strong></td>';
        $html .= '<td style="width: 10%"><strong>IMPORTE IVA</td>';
        $html .= '<td style="width: 10%"><strong>IMPORTE</strong></td>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';

        foreach($order_details as $o)
        {
            //$pneto = round(($o['total_price']-($o['quantity']*$o['discount'])),2);
            $pneto = round(($o['rate']-$o['discount']),2);
            //$base = round(($o['rate']-$o['discount']),2);
            if($o['amount'])
            {
                $base = round(($pneto)-($o['amount']/$o['quantity']),2);
                $punitario = round(($o['rate']-$o['discount']-($o['amount']/$o['quantity'])),2);
            }
            else
            {
                $base = $pneto;
                $punitario = round(($o['rate']-$o['discount']),2);
                //$importe = $pneto;
            }
            $importe = round(($o['total_price']-($o['quantity']*$o['discount']))-$o['amount'],2);
            $html .= '<tr>';
            $html .= '<td style="">'.$o['category_clave'].'</td>';
            $html .= '<td style="">'.$o['quantity'].'</td>';
            $html .= '<td style="">'.$o['unit_name'].'</td>';
            $html .= '<td style="">'.$o['product_name'].'</td>';
            $html .= '<td style="">'.$punitario.'</td>';
            $html .= '<td style="">16.00</td>';
            $html .= '<td style="">'.round($o['amount']/$o['quantity'],2).'</td>';
            $html .= '<td style="">'.round($o['amount'],2).'</td>';
            $html .= '<td style="">'.$importe.'</td>';
            $html .= '</tr>';
        }

        $html .= '</tbody>';
        $html .= '</table>';




        $html .= '<table style="font-size:7pt;width: 100%;margin-top: 1px" border="1" cellspacing="0" cellpadding="3">';
        $html .= '<tbody>';
        $html .= '<tr>';
        $html .= '<td style="width: 80%;" rowspan="5">Si se realizan pagos con cheques nominativos y estos son&nbsp;devueltos por el banco por fondos insuficientes se aplicara&nbsp;un cargo a su cuenta del 20% sobre el importe del cheque&nbsp;devuelto como indemnizacion de acuerdo con la ley de&nbsp;L.T.O.C. Art. 193 y dejaremos de surtir sus pedidos hasta el&nbsp;cobro de la indemnizacion.</td>';
        $html .= '<td style="">SUBTOTAL</td>';
        $html .= '<td style="">'.$subtotal_.'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="">DESCUENTO</td>';
        $html .= '<td style="">0.00</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="">IEPS</td>';
        $html .= '<td style="">0.00</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style="">IVA 16%</td>';
        $html .= '<td style="">'.round($order['order']->tax_amount,2).'</td>';
        $html .= '</tr>';
        $html .= '<tr>';
        $html .= '<td style=""><strong>TOTAL</strong></td>';
        $html .= '<td style=""><strong>'.$total_.'</strong></td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';


        $html .= '<table style="font-size:7pt;margin-top:5px;" border="1" width="100%" cellspacing="0" cellpadding="3">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<td style="width: 20%;"><strong>ARTICULO</strong></td>';
        $html .= '<td style="width: 80%;"><strong>DESCRIPCION</strong></td>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        $html .= '<tr>';
        $path = base_url('assets/timbrados/'.$order['order']->order_id.'.png');
        $html .= '<td style="width: 20%;"><img src="'.$urlQr.'" /></td>';
        $html .= '<td style="width: 80%;">';
        $html .= '<p>*** '.$numeroletras.' Pesos Mexicanos</p>';
        $html .= '<p>ANTES DE FIRMAR SUPLICAMOS CHECAR Y REVISAR TU MERCANCIA. NO ACEPTAMOS RECLAMACIONES 0.00<br />DEBE(MOS) Y PAGARE(MOS) Incondicionalmente por este pagare mercatil el<br />A la orden de DISTRIBUIDORA DE PERFUMERIA Y POPULARES S.A. DE C.V. la factura N&deg;<br />en la ciudad de Coatzacoalcos. Ver. la cantidad de&nbsp; *** '.$numeroletras.' Pesos MXN ***</p>';
        $html .= '<p>En caso de no resibir el pago total a la fecha limite del credito se le generar un cargo financiero a su<br />cuenta del 2% mas IVA por concepto de demora que se generasobre el saldo vencido.</p>';
        $html .= '</td>';
        $html .= '</tr>';
        $html .= '</tbody>';
        $html .= '</table>';

        $html .= '<p style="text-align: center;font-size:7pt">&nbsp;</p>';
        $html .= '<h4 style="font-size:10pt">SELLO DIGITAL DEL EMISOR</h4>';
        $html .= '<p style="font-size:10pt">'.$timbre_selloCFD.'</p>';
        $html .= '<p>&nbsp;</p>';
        $html .= '<h4 style="font-size:10pt">SELLO DIGITAL DEL SAT</h4>';
        $html .= '<p style="font-size:10pt">'.$timbre_selloSAT.'</p>';
        $html .= '<p>&nbsp;</p>';
        $html .= '<h4 style="font-size:10pt">CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACION DIGITAL DEL SAT</h4>';
        $html .= '<p style="font-size:10pt">'.$cadena_sat.'</p>';
        $html .= '<p style="font-size:10pt;text-align: center;">ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI</p>';
        $html.='</div>';
        return $html;

    }

    public function imprime_html_salva($xml_archivo,$order,$receptor,$order_details,$urlQr)
    {
        if(file_exists($xml_archivo)==false)
        {
            return 'ERROR 1, NO EXISTE XML, MUY  POSIBLEMENTE ES UNA PRUEBA FALLIDA';
        }
        if(filesize($xml_archivo)<100)
        {
            return 'ERROR 2, XML INVALIDO';
        }

        $xml = simplexml_load_file($xml_archivo);
        $ns = $xml->getNamespaces(true);
        foreach($ns as $prefijo => $uri)
        {
            $xml->registerXPathNamespace($prefijo, $uri);
        }

        foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante)
        {
            $cambio= $cfdiComprobante['TipoCambio'];

            $certificado_no=$cfdiComprobante['NoCertificado'];
            $fecha_expedicion= $cfdiComprobante['Fecha'];
            $folio=$cfdiComprobante['Folio'];
            $LugarExpedicion=autoformato_impresion($cfdiComprobante['LugarExpedicion']);

            $forma_pago=autoformato_impresion( $cfdiComprobante['FormaPago']);
            $forma_pago = formato_forma_pago33($forma_pago);

            $metodo_pago= autoformato_impresion($cfdiComprobante['MetodoPago']);
            $metodo_pago=formato_metodo_pago33($metodo_pago);

            $subtotal=$cfdiComprobante['SubTotal'];
            $subtotal_=number_format((string)$subtotal,2);

            $total=$cfdiComprobante['Total'];
            $total_=number_format((string)$total,2);

            $numeroletras=num2letras($total,'  ');

            $longitud=95;

            foreach ($xml->xpath('//tfd:TimbreFiscalDigital') as $tfd)
            {
                $timbre_selloCFD= $tfd['SelloCFD'];
                $timbre_selloCFD= wordwrap($timbre_selloCFD,$longitud,'<br>',true);
                $timbre_fecha= $tfd['FechaTimbrado'];
                $timbre_uuid= $uuid=$tfd['UUID'];
                $timbre_noCertificadoSAT= $tfd['NoCertificadoSAT'];
                $timbre_version= $tfd['Version'];
                $timbre_selloSAT = $sellosat=$tfd['SelloSAT'];
                $timbre_selloSAT = wordwrap($timbre_selloSAT,$longitud,'<br>',true);
            }

            $cadena_sat='||'.$timbre_version.'|'.$timbre_uuid.'|.'.$timbre_fecha.'|'.$timbre_selloCFD.'|'.$timbre_noCertificadoSAT.'||';
            $cadena_sat = wordwrap($cadena_sat,$longitud,'<br>',true);

            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Receptor') as $Receptor)
            {
                $receptor_rfc=$Receptor['Rfc'];
                $receptor_nombre=autoformato_impresion($Receptor['Nombre']);
                $uso_CFDi=$Receptor['UsoCFDI'];

            }

            foreach ($xml->xpath('//cfdi:Comprobante//cfdi:Emisor') as $Emisor)
            {
                $emisor_rfc=$Emisor['Rfc'];
                $emisor_nombre= autoformato_impresion($Emisor['Nombre']);
                $regimen_fiscal=$Emisor['RegimenFiscal'];
            }
        }

        echo '<table style="width: 100%; height: 100px;">';
        echo '<tbody>';
        echo '<tr>';
        echo '<td style="width: 20.7519%;"><img src="http://dipepsa.mx/assets/website/maqueta/images/logo-dipepsa.png" /></td>';
        echo '</td>';
        echo '<td style="width: 44.9023%; text-align: center;">';
        echo '<h3>DISTRIBUIDORA DE PERFUMERIA Y POPULARES<br />S.A. DE C.V</h3>';
        echo '<p>DPP8607174L9</p>';
        echo 'PERSONAS MORALES REGIMEN GENERAL DE LEY&nbsp;CAR. COATZACOALCOS A BARRILLAS&nbsp;REDIO SAN JOAQUIN KM';
        echo '1+300&nbsp;COATZACOALCOS VER</td>';
        echo '<td style="width: 31.4887%; text-align: center;">';
        echo '<table style="height: 215px; width: 100%; float: left;" border="1" cellspacing="0"><caption>&nbsp;</caption>';
        echo '<tbody>';
        echo '<tr style="height: 43.8px;">';
        echo '<td style="width: 98.4px; height: 43.8px;">';
        echo '<h2><strong><span style="color: #ff0000;">FACTURA</span></strong></h2>';
        echo '</td>';
        echo '<td style="width: 181.6px; height: 43.8px;">&nbsp;</td>';
        echo '</tr>';
        echo '<tr style="height: 34px;">';
        echo '<td style="width: 98.4px; height: 34px;">FOLIO FISCAL:</td>';
        echo '<td style="width: 181.6px; height: 34px;">'.$timbre_uuid.'</td>';
        echo '</tr>';
        echo '<tr style="height: 17px;">';
        echo '<td style="width: 98.4px; height: 17px;">CERTIFICADO :</td>';
        echo '<td style="width: 181.6px; height: 17px;">'.$certificado_no.'</td>';
        echo '</tr>';
        echo '<tr style="height: 34px;">';
        echo '<td style="width: 98.4px; height: 34px;">CERTIFICADO SAT :</td>';
        echo '<td style="width: 181.6px; height: 34px;">'.$timbre_noCertificadoSAT.'</td>';
        echo '</tr>';
        echo '<tr style="height: 34px;">';
        echo '<td style="width: 98.4px; height: 34px;">FECHA DE EXP. :</td>';
        echo '<td style="width: 181.6px; height: 34px;">'.$fecha_expedicion.'</td>';
        echo '</tr>';
        echo '<tr style="height: 17px;">';
        echo '<td style="width: 98.4px; height: 17px;">FOLIO:</td>';
        echo '<td style="width: 181.6px; height: 17px;">'.$folio.'</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>&nbsp;';
        echo '</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '<table style="width: 100%;" border="1" cellspacing="0">';
        echo '<tbody>';
        echo '<tr>';
        echo '<td style="border-color: #DDDDDD;" scope="col">EXPEDIDO EN<br />'.$order['order']->store_name.'<br/>';
        echo $order['order']->store_address.'<br/>';
        echo 'LUGAR Y FEC. DE EXPEDICION: '.$LugarExpedicion.' '.$fecha_expedicion.'</br>';
        echo 'RFC EMISOR	: '.$emisor_rfc.'</td>';
        echo '<td>FACTURAR A: '.$receptor['nombreReceptor'].'</br> RFC RECEPTOR:     '.$receptor_rfc.'</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '</table>';
        echo '<table style="height: 63px;margin-top:15px" border="1" width="100%" cellspacing="0" cellpadding="0">';
        echo '<tbody>';
        echo '<tr>';
        echo '<td style="width: 72px;"><strong>CONDICIONES COMERCIALES</strong></td>';
        echo '<td style="width: 72px;"><strong>FORMA DE PAGO</strong></td>';
        echo '<td style="width: 72px;"><strong>METODO DE PAGO</strong></td>';
        echo '<td style="width: 72px;"><strong>USO CFDI</strong></td>';
        echo '<td style="width: 72px;"><strong>FECHA Y HORA DE EMISION</strong></td>';
        echo '<td style="width: 72.8px;"><strong>MONEDA</strong></td>';
        echo '<td style="width: 72.8px;"><strong>CAMBIO</strong></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="width: 72px;">CONTADO</td>';
        echo '<td style="width: 72px;">'.$forma_pago.'</td>';
        echo '<td style="width: 72px;">'.$metodo_pago.'</td>';
        echo '<td style="width: 72px;">'.$uso_CFDi.'</td>';
        echo '<td style="width: 72px;">'.$fecha_expedicion.'</td>';
        echo '<td style="width: 72.8px;">MXN PESOS MEXICANOS</td>';
        echo '<td style="width: 72.8px;">'.$cambio.'</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '<table style="margin-top:15px" float: left;" border="1" width="100%" cellspacing="0">';
        echo '<thead>';
        echo '<tr style="text-align: left;">';
        echo '<td style="width: 67.2px;"><strong>CLAVE</strong></td>';
        echo '<td style="width: 67.2px;"><strong>CANTIDAD</strong></td>';
        echo '<td style="width: 67.2px;"><strong>UNIDAD</strong></td>';
        echo '<td style="width: 67.2px;"><strong>DESCRIPCIÓN</strong></td>';
        echo '<td style="width: 67.2px;"><strong>PRECIO UNITARIO</strong></td>';
        echo '<td style="width: 67.2px;"><strong>% IVA TASA</strong></td>';
        echo '<td style="width: 67.2px;"><strong>IVA </strong></td>';
        echo '<td style="width: 68px;"><strong>IMPORTE IVA</td>';
        echo '<td style="width: 68px;"><strong>IMPORTE</strong></td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach($order_details as $o)
        {
            //$pneto = round(($o['total_price']-($o['quantity']*$o['discount'])),2);
            $pneto = round(($o['rate']-$o['discount']),2);
            //$base = round(($o['rate']-$o['discount']),2);
            if($o['amount'])
            {
                $base = round(($pneto)-($o['amount']/$o['quantity']),2);
                $punitario = round(($o['rate']-$o['discount']-($o['amount']/$o['quantity'])),2);
            }
            else
            {
                $base = $pneto;
                $punitario = round(($o['rate']-$o['discount']),2);
                //$importe = $pneto;
            }
            $importe = round(($o['total_price']-($o['quantity']*$o['discount']))-$o['amount'],2);
            echo '<tr>';
            echo '<td style="width: 67.2px;">'.$o['category_clave'].'</td>';
            echo '<td style="width: 67.2px;">'.$o['quantity'].'</td>';
            echo '<td style="width: 67.2px;">'.$o['unit_name'].'</td>';
            echo '<td style="width: 67.2px;">'.$o['product_name'].'</td>';
            echo '<td style="width: 67.2px;">'.$punitario.'</td>';
            echo '<td style="width: 67.2px;">16.00</td>';
            echo '<td style="width: 67.2px;">'.round($o['amount']/$o['quantity'],2).'</td>';
            echo '<td style="width: 68px;">'.round($o['amount'],2).'</td>';
            echo '<td style="width: 68px;">'.$importe.'</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
        echo '<table style="width: 100%;" border="1" cellspacing="0" cellpadding="3">';
        echo '<tbody>';
        echo '<tr>';
        echo '<td style="width: 80%; border-color: #ffffff;" rowspan="5">Si se realizan pagos con cheques nominativos y estos son&nbsp;devueltos por el banco por fondos insuficientes se aplicara&nbsp;un cargo a su cuenta del 20% sobre el importe del cheque&nbsp;devuelto como indemnizacion de acuerdo con la ley de&nbsp;L.T.O.C. Art. 193 y dejaremos de surtir sus pedidos hasta el&nbsp;cobro de la indemnizacion.</td>';
        echo '<td style="border-color: #ffffff;">SUBTOTAL</td>';
        echo '<td style="border-color: #ffffff;">'.$subtotal_.'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="border-color: #ffffff;">DESCUENTO</td>';
        echo '<td style="border-color: #ffffff;">0.00</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="border-color: #ffffff;">IEPS</td>';
        echo '<td style="border-color: #ffffff;">0.00</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="border-color: #ffffff;">IVA 16%</td>';
        echo '<td style="border-color: #ffffff;">'.round($order['order']->tax_amount,2).'</td>';
        echo '</tr>';
        echo '<tr>';
        echo '<td style="border-color: #ffffff;"><strong>TOTAL</strong></td>';
        echo '<td style="border-color: #ffffff;"><strong>'.$total_.'</strong></td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '<table style="height: 68px;margin-top:10px;" border="1" width="100%" cellspacing="0" cellpadding="3">';
        echo '<thead>';
        echo '<tr>';
        echo '<td style="width: 193.6px;"><strong>ARTICULO</strong></td>';
        echo '<td style="width: 194.4px;"><strong>DESCRIPCION</strong></td>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        echo '<tr>';
        echo '<td style="width: 15%;"><img src="'.$urlQr.'" /></td>';
        echo '<td style="width: 85%;">';
        echo '<p>*** '.$numeroletras.'</p>';
        echo '<p>ANTES DE FIRMAR SUPLICAMOS CHECAR Y REVISAR TU MERCANCIA. NO ACEPTAMOS RECLAMACIONES 0.00<br />DEBE(MOS) Y PAGARE(MOS) Incondicionalmente por este pagare mercatil el<br />A la orden de DISTRIBUIDORA DE PERFUMERIA Y POPULARES S.A. DE C.V. la factura N&deg;<br />en la ciudad de Coatzacoalcos. Ver. la cantidad de&nbsp; *** '.$numeroletras.' Pesos MXN ***</p>';
        echo '<p>En caso de no resibir el pago total a la fecha limite del credito se le generar un cargo financiero a su<br />cuenta del 2% mas IVA por concepto de demora que se generasobre el saldo vencido.</p>';
        echo '</td>';
        echo '</tr>';
        echo '</tbody>';
        echo '</table>';
        echo '<p style="text-align: center;">&nbsp;</p>';
        echo '<h4>SELLO DIGITAL DEL EMISOR</h4>';
        echo '<p>'.$timbre_selloCFD.'</p>';
        echo '<p>&nbsp;</p>';
        echo '<h4>SELLO DIGITAL DEL SAT</h4>';
        echo '<p>'.$timbre_selloSAT.'</p>';
        echo '<p>&nbsp;</p>';
        echo '<h4>CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACION DIGITAL DEL SAT</h4>';
        echo '<p>'.$cadena_sat.'</p>';
        echo '<p style="text-align: center;">ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI</p>';

        return $html;

    }

    function autoformato_impresion($txt)
    {
        //$txt=utf8_decode(utf8_decode($txt));
        $txt=utf8_decode($txt);
        return $txt;
    }

    function formato_forma_pago33($forma_pago)
    {
        $forma_pago=str_replace('01','Efectivo (01)',$forma_pago);
        $forma_pago=str_replace('02','Cheque Nominativo (02)',$forma_pago);
        $forma_pago=str_replace('03','Transferencia electrónica de fondos (03)',$forma_pago);
        $forma_pago=str_replace('04','Tarjetas de crédito (04)',$forma_pago);
        $forma_pago=str_replace('05','Monederos electrónicos (05)',$forma_pago);
        $forma_pago=str_replace('06','Dinero electrónico (06)',$forma_pago);
        //$forma_pago=str_replace('07','Tarjetas digitales (07)',$forma_pago);
        $forma_pago=str_replace('08','Vales de despensa (08)',$forma_pago);
        //$forma_pago=str_replace('09','Bienes (09)',$forma_pago);
        //$forma_pago=str_replace('10','Servicio (10)',$forma_pago);
        //$forma_pago=str_replace('11','Por cuenta de tercero (11)',$forma_pago);
        $forma_pago=str_replace('12','Dación en pago (12)',$forma_pago);
        $forma_pago=str_replace('13','Pago por subrogación (13)',$forma_pago);
        $forma_pago=str_replace('14','Pago por consignación (14)',$forma_pago);
        $forma_pago=str_replace('15','Condonación (15)',$forma_pago);
        //$forma_pago=str_replace('16','Cancelación (16)',$forma_pago);
        $forma_pago=str_replace('17','Compensación (17)',$forma_pago);
        $forma_pago=str_replace('23','Novación (23)',$forma_pago);
        $forma_pago=str_replace('24','Confusión (24)',$forma_pago);
        $forma_pago=str_replace('25','Remisión de deuda (25)',$forma_pago);
        $forma_pago=str_replace('26','Prescripción o caducidad (26)',$forma_pago);
        $forma_pago=str_replace('27','A satisfacción del acreedor (27)',$forma_pago);
        $forma_pago=str_replace('28','Tarjeta de Débito (28)',$forma_pago);
        $forma_pago=str_replace('29','Tarjeta de Servicio (29)',$forma_pago);
        $forma_pago=str_replace('99','Por definir (99)',$forma_pago);
        /*
        01 – Efectivo
        02 – Cheque
        03 – Transferencia
        04 – Tarjetas de crédito
        05 – Monederos electrónicos
        06 – Dinero electrónico
        07 – Tarjetas digitales
        08 – Vales de despensa
        09 – Bienes
        10 – Servicio
        11 – Por cuenta de tercero
        12 – Dación en pago
        13 – Pago por subrogación
        14 – Pago por consignación
        15 – Condonación
        16 – Cancelación
        17 – Compensación
        98 – NA
        99 – Otros
        */
        $forma_pago=strtoupper($forma_pago);
        return $forma_pago;
    }
}