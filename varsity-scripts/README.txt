
# convert gVCF to VCF and filter


rsync --progress -av ~/wgs/CS_10842/CS_10842-cf3.g.vcf.gz* .




# load dbSNP/EVA
bcftools view -r chr29 GCA_000002285.2_current_ids.vcf.gz | bcftools view -v snps -Oz -o cf3-eva.v3.snps.vcf.gz
bcftools view -r chr29 GCA_000002285.2_current_ids.vcf.gz | bcftools view -v indels -Oz -o cf3-eva.v3.indels.vcf.gz
bcftools query -f '%CHROM|%POS|%REF|%ALT\t%ID\n' cf3-eva.v3.snps.vcf.gz > /Users/Ellen/Git/CanvasDB/tmpfile_dir/cf3_snp151_parsed.txt
bcftools query -f '%CHROM|%POS|%REF|%ALT\t%ID\n' cf3-eva.v3.indels.vcf.gz > /Users/Ellen/Git/CanvasDB/tmpfile_dir/cf3_snp151_indels_parsed.txt


BoT_33129 BoT_33421 BoT_33725 BoT_37630 BoT_37873