<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" />

<xsl:template match="/">
	
		<xsl:apply-templates select="mulka/export/classes/class"/>
	
</xsl:template>

<xsl:template match="class">
	<xsl:if test="position() &gt; 1">,</xsl:if>

	{
		"<xsl:value-of select="name" />" : [
			<xsl:for-each select="result-list/competitor">
				<xsl:variable name="competitor-id"><xsl:value-of select="@object-id" /></xsl:variable>
				<xsl:if test="position() &gt; 1">,</xsl:if>
				[
					"<xsl:value-of select="@rank" />"
                , "<xsl:apply-templates select="/mulka/export/competitors/competitor[@object-id=$competitor-id]/club"/>"
                , "<xsl:value-of select="/mulka/export/competitors/competitor[@object-id=$competitor-id]/name" />"
                ,"<xsl:value-of select="/mulka/export/competitors/competitor[@object-id=$competitor-id]/status/@type" />"
				]
			</xsl:for-each>
		]
	}

</xsl:template>

</xsl:stylesheet>