FROM container-registry.platta-net.hel.fi/hki-kanslia-wordpress-base/openshift-wordpress-base

# Replace wp-config.php with a custom version
COPY wp-config.php /opt/app-root/src/wp-config.php

ARG MOUNT_SECRET="false"
ARG COMPOSER_AUTH="{}"

# build volume auth
RUN mkdir -p /opt/app-root/src/.config/composer && \
    if [ -n "$MOUNT_SECRET" ] && [ "${MOUNT_SECRET,,}" = "true" ]; then \
        cp /mnt/secrets/* /opt/app-root/src/.config/composer; \
    fi

RUN composer config repositories.aula-wp-theme vcs https://github.com/City-of-Helsinki/aula-wp-theme &&\
    composer require city-of-helsinki/aula-wp-theme && rm -f /opt/app-root/src/.config/composer/auth.json
