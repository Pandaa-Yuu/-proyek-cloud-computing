#!/bin/bash
TANGGAL=$(date +%Y-%m-%d_%H-%M-%S)
LOKASI="/home/$USER/proyek-kos/backup_kos_$TANGGAL.sql"

docker exec mysql_db /usr/bin/mysqldump -u kos_user -pkospassword kos_db > $LOKASI
echo "Backup berhasil disimpan di: $LOKASI"
