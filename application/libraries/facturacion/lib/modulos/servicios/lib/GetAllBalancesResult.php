<?php
// <!-- phpDesigner :: Timestamp [11/03/2016 05:58:03 p. m.] -->
/**
 * MultiFacturas.com 2016
 * Author: I.R.G.
 */
class GetAllBalancesResult {
    public static function fromArray($array) {
        // Se verifica que sea un array
        if(!is_array($array)) {
            throw new Exception(sprintf("%s::%s El parámetro debe ser un array.", __CLASS__, __FUNCTION__));
        }

        // Se verifica que exista el elemento 'GetAllBalancesResult'
        if(!array_key_exists(__CLASS__, $array)) {
            throw new Exception(sprintf("%s::%s No se encontró el elemento '%s'.", __CLASS__, __FUNCTION__, __CLASS__));
        }

        // Se parsea la respuesta
        return ArrayOfAccountBalance::fromXML($array[__CLASS__]);
    }
}