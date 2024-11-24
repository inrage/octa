import type { Bud } from "@roots/bud";
import path from "path";

export default async (bud: Bud) => {
  const addEntries = async (types: String[]) => {
    const combinedEntries = {};

    await Promise.all(
      types.map(async (type) => {
        (await bud.glob([`@styles/${type}`, `@src/scripts/${type}`]))
          .flat()
          .forEach((item) => {
            const assetName = `${type}/${path.basename(item, path.extname(item))}`;
            const assetType = item.includes("/styles/")
              ? "@styles"
              : "@scripts";
            combinedEntries[assetName] = [
              ...(combinedEntries[assetName] || []),
              `${assetType}/${assetName}`,
            ];
          });
      }),
    );

    return combinedEntries;
  };

  bud
    .proxy(bud.env.get('WP_HOME'))
    .serve(`http://localhost:3000`);

  bud
    .watch([bud.path(`resources/views`), bud.path(`app`)])

    .entry(`app`, [`@scripts/app`, `@styles/app`])
    .entry(`editor`, [
      `@scripts/editor`,
      `@styles/editor`,
      ...bud.globSync(`@styles/blocks/**/*.{scss,css}`),
    ])
    .entry({
      ...(await addEntries([
        "blocks/acf",
        "blocks/inr",
        "blocks/core",
        "components",
        "pages",
      ])),
    })
    .copyDir(`images`)

    .setPublicPath(`/dist/`)
    .experiments(`topLevelAwait`, true)

    .wpjson.setSettings({
      color: {
        custom: false,
        customDuotone: false,
        customGradient: false,
        defaultDuotone: false,
        defaultGradients: false,
        defaultPalette: false,
        duotone: [],
        text: true,
        background: true,
      },
      custom: {
        spacing: {},
        typography: {
          "font-size": {},
          "line-height": {},
        },
      },
      layout: {
        contentSize: `64rem`,
      },
      spacing: {
        padding: true,
        units: [`px`, `%`, `em`, `rem`, `vw`, `vh`],
      },
      typography: {
        customFontSize: false,
        dropCap: undefined,
      },
    })
    .setStyles({
      spacing: {
        blockGap: `1.5rem`,
        padding: {
          left: `1.5rem`,
          right: `1.5rem`,
        },
      },
      typography: {
        fontFamily: `var(--wp--preset--font-family--sans)`,
        fontSize: `var(--wp--preset--font-size--normal)`,
      },
    })
    .setPath(bud.path(`public/dist/theme.json`));

  bud.when(`tailwind` in bud, ({ wpjson }) =>
    wpjson.useTailwindColors().useTailwindFontFamily().useTailwindFontSize(),
  );

  bud
    .when(`eslint` in bud, ({ eslint }) =>
      eslint
        .extends([
          `@roots/eslint-config/sage`,
          `@roots/eslint-config/typescript`,
          `plugin:react/jsx-runtime`,
        ])
        .setFix(true)
        .setFailOnWarning(bud.isProduction),
    )

    /**
     * Stylelint config
     */
    .when(`stylelint` in bud, ({ stylelint }) =>
      stylelint
        .extends([
          `@roots/sage/stylelint-config`,
          `@roots/bud-tailwindcss/stylelint-config`,
        ])
        .setFix(true)
        .setFailOnWarning(bud.isProduction),
    );
};
