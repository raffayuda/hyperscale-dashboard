
// this file is generated — do not edit it


declare module "svelte/elements" {
	export interface HTMLAttributes<T> {
		'data-sveltekit-keepfocus'?: true | '' | 'off' | undefined | null;
		'data-sveltekit-noscroll'?: true | '' | 'off' | undefined | null;
		'data-sveltekit-preload-code'?:
			| true
			| ''
			| 'eager'
			| 'viewport'
			| 'hover'
			| 'tap'
			| 'off'
			| undefined
			| null;
		'data-sveltekit-preload-data'?: true | '' | 'hover' | 'tap' | 'off' | undefined | null;
		'data-sveltekit-reload'?: true | '' | 'off' | undefined | null;
		'data-sveltekit-replacestate'?: true | '' | 'off' | undefined | null;
	}
}

export {};


declare module "$app/types" {
	export interface AppTypes {
		RouteId(): "/" | "/billing" | "/deployments" | "/profile" | "/project" | "/project/[slug]" | "/settings" | "/storage";
		RouteParams(): {
			"/project/[slug]": { slug: string }
		};
		LayoutParams(): {
			"/": { slug?: string };
			"/billing": Record<string, never>;
			"/deployments": Record<string, never>;
			"/profile": Record<string, never>;
			"/project": { slug?: string };
			"/project/[slug]": { slug: string };
			"/settings": Record<string, never>;
			"/storage": Record<string, never>
		};
		Pathname(): "/" | "/billing" | "/billing/" | "/deployments" | "/deployments/" | "/profile" | "/profile/" | "/project" | "/project/" | `/project/${string}` & {} | `/project/${string}/` & {} | "/settings" | "/settings/" | "/storage" | "/storage/";
		ResolvedPathname(): `${"" | `/${string}`}${ReturnType<AppTypes['Pathname']>}`;
		Asset(): "/favicon.svg" | string & {};
	}
}