import { V as ensure_array_like, X as attr_class, W as attr, $ as clsx } from "../../../chunks/index2.js";
import { a as databases } from "../../../chunks/sample-data.js";
import { e as escape_html } from "../../../chunks/context.js";
function _page($$renderer, $$props) {
  $$renderer.component(($$renderer2) => {
    let activeDatabases, totalStorage, backupsEnabled;
    const cloneDatabases = () => databases.map((database) => ({ ...database }));
    let databases$1 = cloneDatabases();
    let selectedDb = null;
    activeDatabases = databases$1.filter((database) => database.status === "active").length;
    totalStorage = databases$1.reduce((sum, database) => sum + database.storageSize, 0);
    backupsEnabled = databases$1.filter((database) => database.autoBackup).length;
    $$renderer2.push(`<div class="flex w-full bg-black"><div class="p-6 w-full"><div class="mb-6 flex items-center justify-between"><div><h2 class="text-2xl font-bold text-white mb-2">Storage &amp; Databases</h2> <p class="text-gray-400 text-sm">Manage your databases and storage solutions</p></div> <button class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"><i class="fas fa-plus mr-2"></i>Create Database</button></div> <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6"><div class="bg-gray-900 border border-gray-800 rounded-lg p-5"><div class="flex items-center justify-between mb-2"><span class="text-gray-400 text-sm">Total Databases</span> <i class="fas fa-database text-blue-500"></i></div> <div class="text-2xl font-bold text-white">${escape_html(databases$1.length)}</div></div> <div class="bg-gray-900 border border-gray-800 rounded-lg p-5"><div class="flex items-center justify-between mb-2"><span class="text-gray-400 text-sm">Active</span> <i class="fas fa-check-circle text-green-500"></i></div> <div class="text-2xl font-bold text-white">${escape_html(activeDatabases)}</div></div> <div class="bg-gray-900 border border-gray-800 rounded-lg p-5"><div class="flex items-center justify-between mb-2"><span class="text-gray-400 text-sm">Total Storage</span> <i class="fas fa-hdd text-purple-500"></i></div> <div class="text-2xl font-bold text-white">${escape_html(totalStorage)} GB</div></div> <div class="bg-gray-900 border border-gray-800 rounded-lg p-5"><div class="flex items-center justify-between mb-2"><span class="text-gray-400 text-sm">Backups Enabled</span> <i class="fas fa-cloud-upload-alt text-yellow-500"></i></div> <div class="text-2xl font-bold text-white">${escape_html(backupsEnabled)}</div></div></div> `);
    if (!databases$1.length) {
      $$renderer2.push("<!--[-->");
      $$renderer2.push(`<div class="flex flex-col items-center justify-center py-20"><div class="w-16 h-16 bg-gray-900 border border-gray-800 rounded-lg flex items-center justify-center mb-4"><i class="fas fa-database text-gray-600 text-2xl"></i></div> <h3 class="text-lg font-medium text-white mb-2">No databases yet</h3> <p class="text-gray-400 text-sm mb-6">Create your first database to get started</p> <button class="bg-white text-black px-5 py-2 rounded-lg text-sm font-medium hover:bg-gray-200 transition-colors"><i class="fas fa-plus mr-2"></i>Create Database</button></div>`);
    } else {
      $$renderer2.push("<!--[!-->");
      $$renderer2.push(`<div class="space-y-3"><!--[-->`);
      const each_array = ensure_array_like(databases$1);
      for (let $$index = 0, $$length = each_array.length; $$index < $$length; $$index++) {
        let database = each_array[$$index];
        $$renderer2.push(`<div class="bg-gray-900 border border-gray-800 rounded-lg p-5 hover:border-gray-700 transition-all"><div class="flex items-center justify-between"><div class="flex items-center gap-4 flex-1"><div class="w-12 h-12 bg-black border border-gray-800 rounded-lg flex items-center justify-center"><i class="fas fa-database text-blue-400 text-xl"></i></div> <div class="flex-1"><div class="flex items-center gap-3 mb-1"><h3 class="text-white font-medium">${escape_html(database.name)}</h3> <span${attr_class(`px-2 py-1 text-xs rounded-full ${database.status === "active" ? "bg-green-500/10 text-green-400" : "bg-yellow-500/10 text-yellow-400"}`)}>${escape_html(database.status)}</span></div> <div class="flex flex-wrap items-center gap-4 text-sm text-gray-400"><span class="flex items-center gap-2"><i class="fas fa-server text-xs"></i> ${escape_html(database.type)}</span> <span class="flex items-center gap-2"><i class="fas fa-globe text-xs"></i> ${escape_html(database.region)}</span> <span class="flex items-center gap-2"><i class="fas fa-hdd text-xs"></i> ${escape_html(database.storageSize)} GB</span> `);
        if (database.autoBackup) {
          $$renderer2.push("<!--[-->");
          $$renderer2.push(`<span class="flex items-center gap-2 text-green-400"><i class="fas fa-cloud-upload-alt text-xs"></i> Auto Backup</span>`);
        } else {
          $$renderer2.push("<!--[!-->");
        }
        $$renderer2.push(`<!--]--></div></div></div> <div class="flex items-center gap-2"><button class="px-3 py-2 bg-black border border-gray-800 rounded-lg text-sm text-gray-300 hover:text-white hover:border-gray-700 transition-colors"><i class="fas fa-link mr-2"></i>Connection</button> <button class="px-3 py-2 bg-black border border-gray-800 rounded-lg text-gray-400 hover:text-white hover:border-gray-700 transition-colors" aria-label="Delete database"><i class="fas fa-trash"></i></button></div></div> `);
        if (selectedDb?.id === database.id) {
          $$renderer2.push("<!--[-->");
          $$renderer2.push(`<div class="mt-4 pt-4 border-t border-gray-800 space-y-4"><div class="grid grid-cols-1 md:grid-cols-2 gap-4"><div><label class="block text-xs text-gray-400 mb-1"><span>Host</span> <div class="mt-2 flex items-center gap-2"><input type="text" class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm" readonly${attr("value", database.host)}/> <button class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white" aria-label="Copy host"><i class="fas fa-copy"></i></button></div></label></div> <div><label class="block text-xs text-gray-400 mb-1"><span>Port</span> <input type="text" class="mt-2 w-full px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm" readonly${attr("value", database.port)}/></label></div> <div><label class="block text-xs text-gray-400 mb-1"><span>Username</span> <div class="mt-2 flex items-center gap-2"><input type="text" class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm" readonly${attr("value", database.username)}/> <button class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white" aria-label="Copy username"><i class="fas fa-copy"></i></button></div></label></div> <div><label class="block text-xs text-gray-400 mb-1"><span>Password</span> <div class="mt-2 flex items-center gap-2"><input class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm"${attr("type", "password")} readonly${attr("value", database.password)}/> <button class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white"${attr("aria-label", "Show password")}><i${attr_class(clsx("fas fa-eye"))}></i></button> <button class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white" aria-label="Copy password"><i class="fas fa-copy"></i></button></div></label></div></div> <div><label class="block text-xs text-gray-400 mb-1"><span>Connection String</span> <div class="mt-2 flex items-center gap-2"><input type="text" class="flex-1 px-3 py-2 bg-black border border-gray-800 rounded text-white text-sm font-mono" readonly${attr("value", database.connectionString)}/> <button class="px-3 py-2 bg-black border border-gray-800 rounded text-gray-400 hover:text-white" aria-label="Copy connection string"><i class="fas fa-copy"></i></button></div></label></div></div>`);
        } else {
          $$renderer2.push("<!--[!-->");
        }
        $$renderer2.push(`<!--]--></div>`);
      }
      $$renderer2.push(`<!--]--></div>`);
    }
    $$renderer2.push(`<!--]--></div></div> `);
    {
      $$renderer2.push("<!--[!-->");
    }
    $$renderer2.push(`<!--]-->`);
  });
}
export {
  _page as default
};
