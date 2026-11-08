# Proyek Cloud Computing - Sistem Informasi Kos-Kosan

**Mahasiswa:** Afanda Riji Yuneldi (NIM: 2405005)  
**Dosen Pengampu:** Ego Oktafanda  
**Kelas:** Regular A - S1 Ilmu Komputer, Universitas Rokania  

## Arsitektur & Teknologi
- **Virtual Machine:** Ubuntu Server 26.04 LTS (VMware Workstation)
- **Scaling:** Vertical Scaling (LVM Disk Expansion & Multi-vCPU/RAM)
- **Containerization:** Docker Compose (`php:8.0-alpine`, `mysql:8.0-oracle`, `proxysql`, `prometheus`, `grafana`)
- **Database Proxy:** ProxySQL (Port 6033)
- **Monitoring:** Prometheus (Port 9090) + Grafana (Port 3000)
- **Backup Automation:** Bash Script + Linux Crontab (`backup.sh`)

## Cara Menjalankan
```bash
docker compose up -d
