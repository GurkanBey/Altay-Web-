FROM php:8.1-apache

RUN apt-get update && apt-get install -y default-mysql-client

RUN docker-php-ext-install mysqli
RUN a2enmod rewrite

COPY . /var/www/html/hasta-kayit-php/
RUN mkdir -p /var/log/backups && touch /var/log/backup.log && chmod 666 /var/log/backup.log && chmod 777 /var/log/backups

RUN apt-get install -y cron

COPY scripts/backup.sh /usr/local/bin/backup.sh
RUN chmod +x /usr/local/bin/backup.sh

# crontab dosyasını kopyala
COPY my-crontab /etc/cron.d/my-crontab

# cron formatı doğru olsun diye izinleri ayarla
RUN chmod 0644 /etc/cron.d/my-crontab

# crontab'ı aktif et
RUN crontab /etc/cron.d/my-crontab

# cron çalışsın ve Apache de başlasın
CMD cron && apache2-foreground
