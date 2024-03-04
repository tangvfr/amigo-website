FROM php:8-fpm-alpine3.19
ARG USERNAME
ARG UID
ARG EMAIL
ARG NAME

RUN echo "==============================="
RUN echo "$USERNAME ($UID)"
RUN echo "$NAME ($EMAIL)"
RUN echo "==============================="

# installation bash
RUN apk --no-cache update && apk --no-cache add bash git npm shadow \ 
    && apk --no-cache add 'nodejs>20.11'
#sgdbr postgres
RUN set -ex \
	&& apk --no-cache add postgresql-libs postgresql-dev \
	&& docker-php-ext-install pgsql pdo_pgsql\ 
	&& apk del postgresql-dev
#PHP intl (datetime de EsayAdmin en a besoin)
RUN apk --no-cache add icu-dev 
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl
RUN docker-php-ext-enable intl

# installation de composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
&& php composer-setup.php --install-dir=/usr/local/bin \
&& php -r "unlink('composer-setup.php');"

# installation de symfony
RUN curl -1sLf 'https://dl.cloudsmith.io/public/symfony/stable/setup.alpine.sh' | bash
RUN apk --no-cache add symfony-cli

# installation de Angular
RUN npm install -g typescript  && npm install -g @angular/cli

# gestion user
RUN echo "UID_MAX 9223372036854775807" > /etc/login.defs
RUN adduser -h /home/$USERNAME -D -s /bin/bash -u $UID $USERNAME
USER $USERNAME

# setup git info
RUN git config --global user.email "$EMAIL" \
    && git config --global user.name "$NAME"

#setup terminal
RUN echo "parse_git_branch() {" >> /home/$USERNAME/.bashrc \
    && echo "    git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/ [\1] /'" >> /home/$USERNAME/.bashrc \
    && echo "}" >> /home/$USERNAME/.bashrc

WORKDIR /var/www/html