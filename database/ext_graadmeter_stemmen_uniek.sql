'adminping_user'@'localhost'

ext_graadmeter_stemmen_uniek

SELECT s1.*
FROM `ext_graadmeter_stemmen` s1
WHERE NOT EXISTS (
  SELECT 1
  FROM `ext_graadmeter_stemmen` s2
  WHERE s2.`ip_adres` <> s1.`ip_adres`
    AND SUBSTRING_INDEX(s2.`ip_adres`, '.', 2) = SUBSTRING_INDEX(s1.`ip_adres`, '.', 2)
    AND DATE_FORMAT(s2.`datum`,'%Y-%m-%d') = DATE_FORMAT(s1.`datum`,'%Y-%m-%d')
    AND s2.`datum` < s1.`datum`
    AND TIMESTAMPDIFF(MINUTE, s2.`datum`, s1.`datum`) < 24 * 60
    AND s2.ref_top41_voor = s1.ref_top41_voor
    AND s2.ref_top41_tegen = s1.ref_top41_tegen
    AND s2.ref_tip10_voor = s1.ref_tip10_voor
    AND s2.ref_tip10_tegen = s1.ref_tip10_tegen
)