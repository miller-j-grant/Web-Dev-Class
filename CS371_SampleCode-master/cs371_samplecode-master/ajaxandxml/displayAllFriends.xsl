<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <!-- This XSL stylesheet transforms friends.xml into an HTML document -->
    
    <xsl:template match="/">
    <html>
        <body>
            <ul>
                <xsl:for-each select="friends/friend">
                <li><xsl:value-of select="name"/>
                    <table>

                        <xsl:for-each select="phone">
                            <tr><td> <xsl:value-of  select="@type"/> phone: </td><td><xsl:value-of select="."/></td></tr>
                        </xsl:for-each>
                        <tr><td>Address</td><td></td></tr>
                        <xsl:for-each select="address/line">
                            <tr><td></td><td><xsl:value-of select="."/></td></tr>
                        </xsl:for-each>
                        <tr><td></td><td><xsl:value-of select="address/city"/><xsl:text> </xsl:text><xsl:value-of select="address/state"/><xsl:text> </xsl:text><xsl:value-of select="address/zip"/> </td></tr>
                    
                        <xsl:if test="birthday">
                        <tr><td>Birthday:</td><td><xsl:value-of select="birthday/@month"/><xsl:text>/</xsl:text><xsl:value-of select="birthday/@day"/><xsl:text>/</xsl:text><xsl:value-of select="birthday/@year"/></td></tr>
                        </xsl:if>

                        <xsl:if test="hobby">
                        <tr><td>Hobbies:</td><td><xsl:value-of select="hobby[1]"/></td></tr>
                        <xsl:for-each select="hobby">
                            <xsl:if test="position() != 1">
                            <tr><td></td><td><xsl:value-of select="."/></td></tr>
                            </xsl:if>
                        </xsl:for-each>
                        </xsl:if>

                        <xsl:if test="note">
                        <tr><td>Note:</td><td><xsl:value-of select="note"/></td></tr>
                        </xsl:if>
                    </table>
                </li>
                </xsl:for-each>
            </ul>
        </body>
    </html>
    </xsl:template>



</xsl:stylesheet>