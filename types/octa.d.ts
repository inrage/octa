declare module "*.css"
declare module "*.svg"
declare module "*.jpeg"
declare module "*.jpg"
declare module "*.png"
declare module "*.gif"
declare module "*.webp"

export {};

declare global {
  const roots: {
    register: {
      blocks: (path: string) => void;
      formats: (path: string) => void;
      variations: (path: string) => void;
      plugins: (path: string) => void;
    }
  }
}
