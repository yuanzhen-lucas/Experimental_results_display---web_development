
args <- commandArgs(TRUE)
name <- as.character(args[1])
tissue <- as.character(args[2])
batch <- as.character(args[3])
pcm <- as.character(args[4])


pacman::p_load(hbmcbioR,DT,stringr)
if(str_detect(pcm,"[0-9]+")){
  x_ <- str_split(pcm,";") %>% str_extract_all("[0-9]+") %>% unlist() %>% as.data.frame(stringAsFactors=F)
  numr <- apply(x_,1,FUN=function(x)str_split(x," ") %>% unlist() %>% as.numeric())
  numr <- numr %>% unlist()
  numr <- numr[!is.na(numr)]
  mat <- matrix(numr,nrow = 4,byrow = TRUE)
  pcm=mat
}else{
  pcm=pcm
}

pcmmotif <- universalmotif::create_motif(pcm,alphabet = "DNA",name = "you_give_motif")
pcmtb <- universalmotif::convert_motifs(pcmmotif,"TFBSTools-PWMatrix")
pcmtb_rc <- universalmotif::convert_motifs(universalmotif::motif_rc(pcmmotif),"TFBSTools-PWMatrix")

dir_name <- paste0("/var/www/html/sysbiomotif","/",name,"/",tissue,"/",batch)
if(!dir.exists(dir_name)){
  cmd=glue::glue("mkdir -p {dir_name}")
  system(cmd)
}
motif_name <- paste0(dir_name,"/","motiftotal.Rds")
if(!file.exists(motif_name)){
  pwmlibrary <- TFBSTools::PWMatrixList()
}else{
  pwmlibrary <- read_rds(motif_name)
}


pwm_sim <- TFBSTools::PWMSimilarity(pwmlibrary, pcmtb, method = 'Pearson')
pwm_sim_rc <- TFBSTools::PWMSimilarity(pwmlibrary, pcmtb_rc, method = 'Pearson')
pwm_sim <- pmax(pwm_sim,pwm_sim_rc)
pwm_library_list = lapply(pwmlibrary, function(x){
  data.frame(ID = TFBSTools::name(x))})
pwm_library_dt = dplyr::bind_rows(pwm_library_list)
pwm_library_dt$similarity = pwm_sim
pwm_library_dt = pwm_library_dt[order(-pwm_library_dt$similarity),]
pwm_library_dt$col = rownames(pwm_library_dt)
pwm_sim_1 <- pwmlibrary[[pwm_library_dt$col[[1]] %>% as.numeric()]]

motifpic <- view_motifs(c(pcmmotif,convert_motifs(pwm_sim_1)),show.positions = F)+ylab("")+theme(axis.ticks.y =element_blank(),axis.line.y = element_blank(),axis.text.y = element_blank())
ggplot2::ggsave("/var/www/html/sysbiomotif/motifpic/motifpic.png",motifpic)
cat(pwm_library_dt$similarity[[1]])
                                                                                      