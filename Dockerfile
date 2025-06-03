FROM helsinki.azurecr.io/openshift-wordpress-base:latest

COPY .user.ini wordfence-waf.php /opt/app-root/src/

ARG MOUNT_SECRET="false"
ARG COMPOSER_AUTH="{}"

RUN mkdir -m 777 /tmp/wflogs

# build volume auth
RUN mkdir -p /opt/app-root/src/.config/composer && \
    if [ -n "$MOUNT_SECRET" ] && [ "${MOUNT_SECRET,,}" = "true" ]; then \
        cp /mnt/secrets/* /opt/app-root/src/.config/composer; \
    fi

RUN composer config repositories.oppijaportaali vcs https://github.com/City-of-Helsinki/aula-wp-theme && \
    composer require city-of-helsinki/oppijaportaali && \
    composer config repositories.oppi-school-picker vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-oppi-school-picker && \
    composer require city-of-helsinki/oppi-school-picker && \
    composer config repositories.advanced-custom-fields-pro vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-advanced-custom-fields-pro && \
    composer require acf/advanced-custom-fields-pro && \
    composer config repositories.wpackagist composer https://wpackagist.org && \
    composer require wpackagist-plugin/wp-piwik && \
    composer require wpackagist-plugin/polylang:3.6.7 && \
    composer require wpackagist-plugin/wordfence:8.0.5 && \
    composer require wpackagist-plugin/remove-dashboard-access-for-non-admins:1.2.1 && \
    composer require wpackagist-plugin/safe-svg:2.3.1 && \
    composer require wpackagist-plugin/simple-page-ordering:2.7.3 && \
    composer require wpackagist-plugin/wpo365-login:36.0 && \
    composer require wpackagist-plugin/wpo365-samesite:1.5 && \
    composer require wpackagist-plugin/wp-mail-smtp:4.4.0 && \
    composer config repositories.wpo-365-login-intranet vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-wpo365-login-intranet && \
    composer require wpo365/wpo365-login-intranet && \
    rm -f /opt/app-root/src/.config/composer/auth.json
