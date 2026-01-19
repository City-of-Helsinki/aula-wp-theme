FROM helsinki.azurecr.io/openshift-wordpress-base:latest

COPY .user.ini wordfence-waf.php /opt/app-root/src/

ARG MOUNT_SECRET="false"
ARG COMPOSER_AUTH="{}"
ARG WP_PLUGIN_VERSION_CONNECT_MATOMO=""
ARG WP_PLUGIN_VERSION_POLYLANG=""
ARG WP_PLUGIN_VERSION_WORDFENCE=""
ARG WP_PLUGIN_VERSION_REMOVE_DASHBOARD_ACCESS=""
ARG WP_PLUGIN_VERSION_SAFE_SVG=""
ARG WP_PLUGIN_VERSION_SIMPLE_PAGE_ORDERING=""
ARG WP_PLUGIN_VERSION_WPO365_LOGIN=""
ARG WP_PLUGIN_VERSION_WPO365_SAMESITE=""
ARG WP_PLUGIN_VERSION_WP_MAIL_SMTP=""
ARG WP_PLUGIN_VERSION_WP_SENTRY_INTEGRATION=""
ARG WP_PLUGIN_VERSION_WP_SECURITY_AUDIT_LOG=""
ARG WP_PLUGIN_VERSION_OPPI_SCHOOL_PICKER=""
ARG WP_PLUGIN_VERSION_ACTIVITY_LOG=""

RUN mkdir -m 777 /tmp/wflogs

# build volume auth
RUN mkdir -p /opt/app-root/src/.config/composer && \
    if [ -n "$MOUNT_SECRET" ] && [ "${MOUNT_SECRET,,}" = "true" ]; then \
        cp /mnt/secrets/* /opt/app-root/src/.config/composer; \
    fi

RUN composer config repositories.oppijaportaali vcs https://github.com/City-of-Helsinki/aula-wp-theme && \
    composer require city-of-helsinki/oppijaportaali:dev-dev && \
    composer config repositories.oppi-school-picker vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-oppi-school-picker && \
    composer require city-of-helsinki/oppi-school-picker:$WP_PLUGIN_VERSION_OPPI_SCHOOL_PICKER && \
    composer config repositories.advanced-custom-fields-pro vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-advanced-custom-fields-pro && \
    composer require acf/advanced-custom-fields-pro && \
    composer config repositories.activity-log vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-activity-log && \
    composer require city-of-helsinki/activity-log:$WP_PLUGIN_VERSION_ACTIVITY_LOG && \
    composer config repositories.wpackagist composer https://wpackagist.org && \
    composer require wpackagist-plugin/wp-piwik:$WP_PLUGIN_VERSION_CONNECT_MATOMO && \
    composer require wpackagist-plugin/polylang:$WP_PLUGIN_VERSION_POLYLANG && \
    composer require wpackagist-plugin/wordfence:$WP_PLUGIN_VERSION_WORDFENCE && \
    composer require wpackagist-plugin/remove-dashboard-access-for-non-admins:$WP_PLUGIN_VERSION_REMOVE_DASHBOARD_ACCESS && \
    composer require wpackagist-plugin/safe-svg:$WP_PLUGIN_VERSION_SAFE_SVG && \
    composer require wpackagist-plugin/simple-page-ordering:$WP_PLUGIN_VERSION_SIMPLE_PAGE_ORDERING && \
    composer require wpackagist-plugin/wpo365-login:$WP_PLUGIN_VERSION_WPO365_LOGIN && \
    composer require wpackagist-plugin/wpo365-samesite:$WP_PLUGIN_VERSION_WPO365_SAMESITE && \
    composer require wpackagist-plugin/wp-mail-smtp:$WP_PLUGIN_VERSION_WP_MAIL_SMTP && \
    composer require wpackagist-plugin/wp-sentry-integration:$WP_PLUGIN_VERSION_WP_SENTRY_INTEGRATION && \
    composer require wpackagist-plugin/wp-security-audit-log:$WP_PLUGIN_VERSION_WP_SECURITY_AUDIT_LOG && \
    composer config repositories.wpo-365-login-intranet vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-wpo365-login-intranet && \
    composer require wpo365/wpo365-login-intranet && \
    rm -f /opt/app-root/src/.config/composer/auth.json
