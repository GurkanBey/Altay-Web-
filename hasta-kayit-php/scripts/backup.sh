#!/bin/bash

TIMESTAMP=$(date +%F_%H-%M-%S)
BACKUP_DIR="/var/log/backups"
BACKUP_FILE="$BACKUP_DIR/backup_$TIMESTAMP.sql"
LOG_FILE="/var/log/backup.log"

# MySQL bilgileri
DB_USER="deneme2"
DB_PASS="1234"
DB_NAME="hasta_kayit"

mkdir -p "$BACKUP_DIR"

# Yedek alma
mysqldump --no-tablespaces -h db -u$DB_USER -p$DB_PASS $DB_NAME > "$BACKUP_FILE" 2>> $LOG_FILE

if [ $? -eq 0 ]; then
  echo "[$(date)] Yedek alındı: $(basename $BACKUP_FILE) - $(du -sh $BACKUP_FILE | cut -f1)" >> $LOG_FILE
else
  echo "[$(date)] Yedek alınamadı." >> $LOG_FILE
fi
