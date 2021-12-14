args <- commandArgs(TRUE)

name <- as.character(args[1])
tissue <- as.character(args[2])
batch <- as.character(args[3])
pcm <- as.character(args[4])

library(hbmcbioR)
library(DT)
library(stringr)

if(str_detect(pcm,"[0-9]+")){
  x_ <- str_split(pcm,";") %>% str_extract_all("[0-9]+") %>% unlist() %>% as.data.frame(stringAsFactors=F)
  numr <- apply(x_,1,FUN=function(x)str_split(x," ") %>% unlist() %>% as.numeric())
  numr <- numr %>% unlist()
  numr <- numr[!is.na(numr)]
  mat <- matrix(numr,nrow = 4,byrow = TRUE)
  pcm=mat
}else{
  stop("YOU SHOULD TYPE A MATRIX")
}


dir_name <- paste0("/var/www/html/sysbiomotif","/",name,"/",tissue,"/",batch)
if(!dir.exists(dir_name)){
  cmd=glue::glue("mkdir -p {dir_name}")
  system(cmd)
}


motifpic <- universalmotif::create_motif(pcm,alphabet = "DNA",name = "you_give_motif")
motifpic_tb <- universalmotif::convert_motifs(motifpic,"TFBSTools-PWMatrix")
motifpic_tb@strand <- "+-"
motifpic_tb <- hbmcbioR::motif_get_name(motifpic_tb)

motif_name <- paste0(dir_name,"/","motiftotal.Rds")
if(!file.exists(motif_name)){
  pwmlibrary_raw <- TFBSTools::PWMatrixList()
}else{
  pwmlibrary_raw <- read_rds(motif_name)
}


num_raw <- length(pwmlibrary_raw)
pwmlibrary_raw[[num_raw+1]] <- motifpic_tb
t_pwmlist <- convert_motifs(motifpic_tb)
con_pwmlist <- convert_type(t_pwmlist,"ICM")
width <- stringr::str_count(t_pwmlist["consensus"]) / 1.5
height <- t_pwmlist@icscore / 5
ggsave(paste0("/var/www/html/sysbiomotif/motifindex/",motifpic_tb@name,".png"),view_motifs(t_pwmlist,show.positions = F)+ylab("")+theme(axis.ticks.y =element_blank(),axis.line.y = element_blank(),axis.text.y = element_blank())#labs(title = t_pwmlist["name"])+theme(plot.title = element_text(hjust = 0.5,vjust = -2))
       ,width = width,height = height)
write_rds(pwmlibrary_raw,motif_name)



