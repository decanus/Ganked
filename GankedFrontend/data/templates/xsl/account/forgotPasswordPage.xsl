<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">

    <xsl:template match="/">
        <xsl:param name="isValidHash" select="/doc/@isValidHash" />

        <div class="generic-box -fit -center">
            <xsl:choose>
                <xsl:when test="$isValidHash = 'true'"><h2>Change Password</h2></xsl:when>
                <xsl:otherwise><h2>Forgot Password?</h2></xsl:otherwise>
            </xsl:choose>

            <form method="post" is="ajax-form" novalidate="">

                <xsl:attribute name="action">
                    <xsl:choose>
                        <xsl:when test="$isValidHash = 'true'">//post.ganked.net/action/recover-password</xsl:when>
                        <xsl:otherwise>//post.ganked.net/action/forgot-password</xsl:otherwise>
                    </xsl:choose>
                </xsl:attribute>

                <xsl:if test="$isValidHash = 'true'">
                    <fieldset class="form-group">
                        <div class="input-wrap">
                            <label class="inner">
                                <span class="text">New Password</span>
                                <input type="password" placeholder="New Password" name="newPassword" class="input -big" />
                            </label>
                        </div>
                    </fieldset>

                    <input type="hidden" name="hash" value="{/doc/@hash}"/>
                </xsl:if>

                <xsl:choose>
                    <xsl:when test="$isValidHash = 'true'">
                        <input placeholder="Email" name="email" value="{/doc/@email}" type="hidden"/>
                    </xsl:when>
                    <xsl:otherwise>
                        <div class="input-wrap">
                            <label class="inner">
                                <span class="text">Email</span>
                                <input type="email" placeholder="Email" name="email" value="{/doc/@email}" class="error"/>
                            </label>
                        </div>
                    </xsl:otherwise>
                </xsl:choose>

                <xsl:if test="$isValidHash = 'false'">
                    <label class="-error">It looks like you used an invalid link. Please try again.</label>
                </xsl:if>

                <input type="hidden" name="token"/>

                <button class="submit" type="submit">Reset Password</button>
            </form>
        </div>
    </xsl:template>

</xsl:stylesheet>