FROM helsinki.azurecr.io/openshift-wordpress-base:latest

# Replace wp-config.php with a custom version
COPY --chmod=0664 .user.ini wp-config.php wordfence-waf.php /opt/app-root/src/

ARG MOUNT_SECRET="false"
ARG COMPOSER_AUTH="{}"

RUN mkdir -m 777 /tmp/wflogs

# build volume auth
RUN mkdir -p /opt/app-root/src/.config/composer && \
    if [ -n "$MOUNT_SECRET" ] && [ "${MOUNT_SECRET,,}" = "true" ]; then \
        cp /mnt/secrets/* /opt/app-root/src/.config/composer; \
    fi

RUN composer config repositories.aula-wp-theme vcs https://github.com/City-of-Helsinki/aula-wp-theme && \
    composer require city-of-helsinki/aula-wp-theme && \
    composer config repositories.advanced-custom-fields-pro vcs https://github.com/City-of-Helsinki/wordpress-helfi-plugin-advanced-custom-fields-pro && \
    composer require city-of-helsinki/advanced-custom-fields-pro && \
    rm -f /opt/app-root/src/.config/composer/auth.json
