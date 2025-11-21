# Hyperscale Dashboard (Svelte Static)

Dashboard statik yang meniru pengalaman Hyperscale/Vercel menggunakan **SvelteKit** dan **Tailwind CSS**. Seluruh data di-"seed" secara lokal sehingga aplikasi dapat dibuild menjadi situs statis (SSG) tanpa backend Laravel/PHP.

## Tech Stack

- [SvelteKit](https://kit.svelte.dev/) dengan adapter static
- Tailwind CSS 3
- TypeScript

## Menjalankan Secara Lokal

```bash
npm install
npm run dev
```

Buka `http://localhost:5173`.

## Build Static

```bash
npm run build
npm run preview   # pratinjau hasil build
```

Folder `build/` siap di-deploy ke penyedia static hosting apa pun (Vercel/Netlify dsb).

## Struktur Penting

- `src/lib/data/sample-data.ts` – sumber data statik (projects, deployments, databases).
- `src/routes/+page.svelte` – halaman Project/Dashboard utama.
- `src/routes/deployments` – halaman log deployment beserta filter.
- `src/routes/project/[slug]` – halaman detail proyek.
- `src/routes/storage` – halaman Storage & Database dengan aksi lokal (copy, tambah, hapus).

Silakan ubah data atau gaya sesuai kebutuhan. Jika membutuhkan API sungguhan, cukup ganti sumber data pada masing-masing halaman dengan fetch ke endpoint Anda.*** End Patch

