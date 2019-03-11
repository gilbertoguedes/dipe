<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:PLZ="www.sat.gob.mx/esquemas/ContabilidadE/1_1/PolizasPeriodo" xmlns:PLZB="http://www.sat.gob.mx/esquemas/ContabilidadE/1_1/PolizasPeriodo">
	<!--En esta sección se define la inclusión de las plantillas de utilerías para colapsar espacios -->
	<xsl:include href="http://www.sat.gob.mx/esquemas/utilerias.xslt"/>
	<!-- Con el siguiente método se establece que la salida deberá ser en texto -->
	<xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
	<!-- Aquí iniciamos el procesamiento de la cadena original con su | inicial y el terminador || -->
	<xsl:template match="/">|<xsl:apply-templates select="/PLZ:Polizas"/><xsl:apply-templates select="/PLZB:Polizas"/>||</xsl:template>
	<xsl:template match="PLZ:Polizas">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Version"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Mes"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Anio"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@TipoSolicitud"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@NumOrden"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@NumTramite"/>
		</xsl:call-template>
		<xsl:apply-templates select="./PLZ:Poliza"/>
	</xsl:template>
	<xsl:template match="PLZ:Poliza">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumUnIdenPol"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Concepto"/>
		</xsl:call-template>
		<xsl:apply-templates select="./PLZ:Transaccion"/>
	</xsl:template>
	<xsl:template match="PLZ:Transaccion">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumCta"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Concepto"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Debe"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Haber"/>
		</xsl:call-template>
		<xsl:apply-templates select="./PLZ:CompNal"/>
		<xsl:apply-templates select="./PLZ:CompNalOtr"/>
		<xsl:apply-templates select="./PLZ:CompExt"/>
		<xsl:apply-templates select="./PLZ:Cheque"/>
		<xsl:apply-templates select="./PLZ:Transferencia"/>
		<xsl:apply-templates select="./PLZ:OtrMetodoPago"/>
	</xsl:template>
	<xsl:template match="PLZ:CompNal">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@UUID_CFDI"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZ:CompNalOtr">
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@CFD_CBB_Serie"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CFD_CBB_NumFol"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZ:CompExt">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumFactExt"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZ:Cheque">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Num"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@BanEmisNal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@BanEmisExt"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CtaOri"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Benef"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Monto"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZ:Transferencia">
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@CtaOri"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@BancoOriNal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@BancoOriExt"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CtaDest"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@BancoDestNal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@BancoDestExt"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Benef"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Monto"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZ:OtrMetodoPago">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@MetPagoPol"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Benef"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Monto"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	
<!--Sección B-->	

	<xsl:template match="PLZB:Polizas">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Version"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Mes"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Anio"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@TipoSolicitud"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@NumOrden"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@NumTramite"/>
		</xsl:call-template>
		<xsl:apply-templates select="./PLZB:Poliza"/>
	</xsl:template>
	<xsl:template match="PLZB:Poliza">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumUnIdenPol"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Concepto"/>
		</xsl:call-template>
		<xsl:apply-templates select="./PLZB:Transaccion"/>
	</xsl:template>
	<xsl:template match="PLZB:Transaccion">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumCta"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Concepto"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Debe"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Haber"/>
		</xsl:call-template>
		<xsl:apply-templates select="./PLZB:CompNal"/>
		<xsl:apply-templates select="./PLZB:CompNalOtr"/>
		<xsl:apply-templates select="./PLZB:CompExt"/>
		<xsl:apply-templates select="./PLZB:Cheque"/>
		<xsl:apply-templates select="./PLZB:Transferencia"/>
		<xsl:apply-templates select="./PLZB:OtrMetodoPago"/>
	</xsl:template>
	<xsl:template match="PLZB:CompNal">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@UUID_CFDI"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZB:CompNalOtr">
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@CFD_CBB_Serie"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CFD_CBB_NumFol"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZB:CompExt">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumFactExt"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZB:Cheque">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Num"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@BanEmisNal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@BanEmisExt"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CtaOri"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Benef"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Monto"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZB:Transferencia">
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@CtaOri"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@BancoOriNal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@BancoOriExt"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CtaDest"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@BancoDestNal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@BancoDestExt"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Benef"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Monto"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="PLZB:OtrMetodoPago">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@MetPagoPol"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Benef"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Monto"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>

</xsl:stylesheet>
