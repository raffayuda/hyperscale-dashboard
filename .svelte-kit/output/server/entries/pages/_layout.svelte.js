import { U as head, V as ensure_array_like, W as attr, X as attr_class, Y as store_get, Z as slot, _ as unsubscribe_stores } from "../../chunks/index2.js";
import { g as getContext, e as escape_html } from "../../chunks/context.js";
import "@sveltejs/kit/internal";
import "../../chunks/exports.js";
import "../../chunks/utils.js";
import "clsx";
import "@sveltejs/kit/internal/server";
import "../../chunks/state.svelte.js";
const getStores = () => {
  const stores$1 = getContext("__svelte__");
  return {
    /** @type {typeof page} */
    page: {
      subscribe: stores$1.page.subscribe
    },
    /** @type {typeof navigating} */
    navigating: {
      subscribe: stores$1.navigating.subscribe
    },
    /** @type {typeof updated} */
    updated: stores$1.updated
  };
};
const page = {
  subscribe(fn) {
    const store = getStores().page;
    return store.subscribe(fn);
  }
};
function _layout($$renderer, $$props) {
  $$renderer.component(($$renderer2) => {
    var $$store_subs;
    const navLinks = [
      { href: "/", label: "Projects", match: /^\/$/ },
      {
        href: "/deployments",
        label: "Deployments",
        match: /^\/deployments/
      },
      { href: "/domains", label: "Domains", match: /^\/domains/ },
      { href: "/storage", label: "Storage", match: /^\/storage/ }
    ];
    head("12qhfyh", $$renderer2, ($$renderer3) => {
      $$renderer3.title(($$renderer4) => {
        $$renderer4.push(`<title>Hyperscale Dashboard</title>`);
      });
      $$renderer3.push(`<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/> <link rel="preconnect" href="https://fonts.googleapis.com"/> <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="anonymous"/> <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>`);
    });
    $$renderer2.push(`<div class="min-h-screen bg-black text-white"><div class="border-b border-gray-800 bg-black"><div class="px-6"><nav class="flex items-center justify-between h-14"><div class="flex items-center gap-8"><div class="flex items-center gap-2"><div class="w-6 h-6 bg-white rounded flex items-center justify-center"><i class="fas fa-triangle text-black text-xs"></i></div></div> <!--[-->`);
    const each_array = ensure_array_like(navLinks);
    for (let $$index = 0, $$length = each_array.length; $$index < $$length; $$index++) {
      let link = each_array[$$index];
      if (link.label === "Domains") {
        $$renderer2.push("<!--[-->");
        $$renderer2.push(`<span class="h-14 px-1 text-sm font-medium text-gray-600 flex items-center">Domains</span>`);
      } else {
        $$renderer2.push("<!--[!-->");
        $$renderer2.push(`<a${attr("href", link.href)}${attr_class(`px-1 text-sm font-medium transition-colors -mb-px ${link.match.test(store_get($$store_subs ??= {}, "$page", page).url.pathname) ? "text-white border-b-2 border-white" : "text-gray-400 hover:text-gray-300"}`)}>${escape_html(link.label)}</a>`);
      }
      $$renderer2.push(`<!--]-->`);
    }
    $$renderer2.push(`<!--]--></div> <div class="flex items-center gap-4"><button class="text-gray-400 hover:text-white transition-colors" aria-label="Notifications"><i class="fas fa-bell text-sm"></i></button> <div class="relative"><button class="flex items-center gap-2 text-sm text-gray-300 hover:text-white transition-colors"><div class="w-7 h-7 bg-gray-800 rounded-full flex items-center justify-center"><i class="fas fa-user text-xs"></i></div> <span class="hidden md:inline">raffayuda</span> <i class="fas fa-chevron-down text-xs"></i></button> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]--></div></div></nav></div></div> <!--[-->`);
    slot($$renderer2, $$props, "default", {});
    $$renderer2.push(`<!--]--></div>`);
    if ($$store_subs) unsubscribe_stores($$store_subs);
  });
}
export {
  _layout as default
};
