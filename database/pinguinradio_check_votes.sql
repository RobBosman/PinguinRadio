select *
from ext_graadmeter_stemmen
where (ref_top41_voor <> '' and ref_top41_voor not in(select ref from ext_graadmeter))
   or (ref_top41_tegen <> '' and ref_top41_tegen not in(select ref from ext_graadmeter))
   or (ref_tip10_voor <> '' and ref_tip10_voor not in(select ref from ext_graadmeter))
   or (ref_tip10_tegen <> '' and ref_tip10_tegen not in(select ref from ext_graadmeter));