import * as universal from '../entries/pages/_layout.ts.js';

export const index = 0;
let component_cache;
export const component = async () => component_cache ??= (await import('../entries/pages/_layout.svelte.js')).default;
export { universal };
export const universal_id = "src/routes/+layout.ts";
export const imports = ["_app/immutable/nodes/0.BRN2_Alf.js","_app/immutable/chunks/CnZy0-VH.js","_app/immutable/chunks/pnc30V3v.js","_app/immutable/chunks/B1GlaH1f.js","_app/immutable/chunks/CxN-jAJd.js","_app/immutable/chunks/DiJ8R_XB.js","_app/immutable/chunks/DlLLJDk_.js","_app/immutable/chunks/LzDRUISM.js","_app/immutable/chunks/C6w77hNi.js","_app/immutable/chunks/CXs2w7-C.js","_app/immutable/chunks/BUApaBEI.js","_app/immutable/chunks/BqG5blxG.js"];
export const stylesheets = [];
export const fonts = [];
