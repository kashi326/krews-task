export const useCreateBlob = (file) => {
  const url = URL.createObjectURL(file)
  return { url }
}
