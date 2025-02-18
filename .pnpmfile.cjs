const { dependencies, devDependencies } = require(`./package.json`);

/**
 * bud.js pnpm compatibility shim
 *
 * pnpm allows customizing the package installation process through special functions called hooks.
 * These hooks can be defined in a .pnpmfile.cjs file, which should be located in the same directory
 * as the lockfile. For example, in a monorepo with a shared lockfile, the .pnpmfile.cjs file should
 * be placed in the root of the monorepo.
 *
 * @see {@link https://pnpm.io/pnpmfile} for more information on pnpmfile
 */
module.exports = {
  hooks: {
    /**
     * This hook removes peerDependencies from @roots/* packages because
     * pnpm does not install peerDependencies marked as optional by default.
     * This behavior differs from npm and yarn, which install peerDependencies
     * even if they are marked as optional.
     */
    readPackage(data) {
      // Skip processing if the package is not a @roots/* package
      if (!data.name.startsWith(`@roots`)) return data;

      // Skip processing if the package does not have peerDependencies
      if (!data.peerDependencies) return data;

      // Filter out peerDependencies that are already listed as dependencies or devDependencies
      const peerDependencies = Object.entries(data.peerDependencies)
        .filter(
          ([signifier]) =>
            Object.keys(dependencies || {}).includes(signifier) ||
            Object.keys(devDependencies || {}).includes(signifier),
        )
        .reduce(
          (peerDependencies, [signifier, version]) => ({
            ...peerDependencies,
            [signifier]: version,
          }),
          {},
        );

      // Return the package data with the filtered peerDependencies
      // and an empty peerDependenciesMeta object
      return Object.assign(data, {
        peerDependencies,
        peerDependenciesMeta: {},
      });
    },
  },
};
