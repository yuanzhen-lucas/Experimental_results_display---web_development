args <- commandArgs(TRUE)

pcm <- as.character(args[1])
n <- as.integer(args[2])
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


html=hbmcbioR::motif_database_html(pcm=pcm,n=n,by="consensus")
DT::saveWidget(html, "/var/www/html/motifdb/output/output.html")




