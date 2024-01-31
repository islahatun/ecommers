import { createI18n } from 'vue-i18n';
import en from '@/lang/en';
import id from '@/lang/id';

const i18n = createI18n({
  locale: 'en',
  messages: {
    en,
    id,
  },
});

export default i18n;


