<?php
class Parcelspace_Deliveringconfidence_Helper_Data extends Mage_Core_Helper_Data
{
   /*public function isIpAllowed() {
        $allow = true;

        $allowedIps = $this->getGeneralConfig()->getFirewall( null ); // IP/IPs separated by comma 
        if( !empty( $allowedIps ) ) {
            $allowedIps = preg_split( '#\s*,\s*#', $allowedIps, null, PREG_SPLIT_NO_EMPTY );
            if( array_search( Mage::helper( 'core/http' )->getRemoteAddr(), $allowedIps ) === false ) {
                $allow = false;
            }
        }

        return $allow;
    }*/
}
