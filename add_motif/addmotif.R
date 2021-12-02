
pacman::p_load(hbmcbioR,DT,stringr)
motifpic <- universalmotif::read_motifs("/var/www/html/motifdb/motifpic/motifpic")
motifpic_tb <- universalmotif::convert_motifs(motifpic,"TFBSTools-PWMatrix")
pwmlibrary <- read_rds("/var/www/html/motifdb/data/curated_ati_motifs/curated_30N_motif_pwmlist_20211014.rds")
num <- length(pwmlibrary)
pwmlibrary[[num+1]] <- motifpic_tb
write_rds(pwmlibrary,"/var/www/html/motifdb/data/curated_ati_motifs/curated_30N_motif_pwmlist_20211014.rds")
cat(num+1)
