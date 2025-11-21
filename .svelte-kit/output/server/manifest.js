export const manifest = (() => {
function __memo(fn) {
	let value;
	return () => value ??= (value = fn());
}

return {
	appDir: "_app",
	appPath: "_app",
	assets: new Set(["favicon.svg"]),
	mimeTypes: {".svg":"image/svg+xml"},
	_: {
		client: {start:"_app/immutable/entry/start.Dsf65N2F.js",app:"_app/immutable/entry/app.CXUphpdA.js",imports:["_app/immutable/entry/start.Dsf65N2F.js","_app/immutable/chunks/CXs2w7-C.js","_app/immutable/chunks/pnc30V3v.js","_app/immutable/chunks/C6w77hNi.js","_app/immutable/chunks/BUApaBEI.js","_app/immutable/chunks/BqG5blxG.js","_app/immutable/entry/app.CXUphpdA.js","_app/immutable/chunks/pnc30V3v.js","_app/immutable/chunks/CnZy0-VH.js","_app/immutable/chunks/BqG5blxG.js","_app/immutable/chunks/DiJ8R_XB.js","_app/immutable/chunks/3_QQht11.js","_app/immutable/chunks/LzDRUISM.js","_app/immutable/chunks/C6w77hNi.js"],stylesheets:[],fonts:[],uses_env_dynamic_public:false},
		nodes: [
			__memo(() => import('./nodes/0.js')),
			__memo(() => import('./nodes/1.js'))
		],
		remotes: {
			
		},
		routes: [
			
		],
		prerendered_routes: new Set(["/","/deployments","/storage","/project/machine-learning","/project/pemesanan-tiket-bioskop","/project/information-retrieval","/project/hyperscale-kwu"]),
		matchers: async () => {
			
			return {  };
		},
		server_assets: {}
	}
}
})();
