arq=("sae02 sae03 sae05 sae17 sae25 sae32 sae51 sas08 sas12 sas22 sas24 sas32 sas36 sas44 sas38 sas85 sas90 scda6 scd29 scd99 sid15 sin27 sin29 sit30 smg11 smg12 smg23 spa09 srm01 srm02 srm03 srm09 srm12 srm28 srm32 srm36 srm50 srt01 srt03 srt19 srt32 srt36 srt50 svd02 svd08 svd14 svd18 svd62 Mapa SASOU048 srm18")

cd /fs1/save/bk

dir="/files/portal/doclider/relatorios"
for a in $arq;do
	rm $dir/$a*
	cp $a* $dir
done

rm $dir/*.csv