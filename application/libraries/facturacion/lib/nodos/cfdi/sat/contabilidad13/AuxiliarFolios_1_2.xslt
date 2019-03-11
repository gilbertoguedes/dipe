<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:fn="http://www.w3.org/2005/xpath-functions" xmlns:RepAux="http://www.sat.gob.mx/esquemas/ContabilidadE/1_3/AuxiliarFolios">
	<!--En esta sección se define la inclusión de las plantillas de utilerías para colapsar espacios -->
	<xsl:include href="utilerias.xslt"/>
	<!-- Con el siguiente método se establece que la salida deberá ser en texto -->
	<xsl:output method="text" version="1.0" encoding="UTF-8" indent="no"/>
	<!-- Aquí iniciamos el procesamiento de la cadena original con su | inicial y el terminador || -->
	<xsl:template match="/">|<xsl:apply-templates select="/RepAux:RepAuxFol"/>||</xsl:template>
	<xsl:template match="RepAux:RepAuxFol">
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
		<xsl:apply-templates select="./RepAux:DetAuxFol"/>
	</xsl:template>
	<xsl:template match="RepAux:DetAuxFol">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumUnIdenPol"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@Fecha"/>
		</xsl:call-template>
		<xsl:apply-templates select="./RepAux:ComprNal"/>
		<xsl:apply-templates select="./RepAux:ComprNalOtr"/>
		<xsl:apply-templates select="./RepAux:ComprExt"/>
	</xsl:template>
	<xsl:template match="RepAux:ComprNal">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@UUID_CFDI"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@MetPagoAux"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@MontoTotal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="RepAux:ComprNalOtr">
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@CFD_CBB_Serie"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@CFD_CBB_NumFol"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@RFC"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@MetPagoAux"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@MontoTotal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
	<xsl:template match="RepAux:ComprExt">
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@NumFactExt"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@MetPagoAux"/>
		</xsl:call-template>
		<xsl:call-template name="Requerido">
			<xsl:with-param name="valor" select="./@MontoTotal"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@Moneda"/>
		</xsl:call-template>
		<xsl:call-template name="Opcional">
			<xsl:with-param name="valor" select="./@TipCamb"/>
		</xsl:call-template>
	</xsl:template>
</xsl:stylesheet>
