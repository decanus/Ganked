class LovelyBox
  module Runners
    class Downloads
      #
      # @param [Array] downloads
      #
      def self.run(downloads)
        threads = []

        downloads.each do |dl|
          threads << Thread.new do
            download_file(dl['source'], dl['target'], dl['filemode'])
          end
        end

        threads.map &:join
      end

      #
      # @param [String] source
      # @param [String] target
      # @param [Integer] mode
      #
      def self.download_file(source, target, mode = 0777)
        puts "Downloading from #{source} to #{target}..."

        File.delete(target) if File.exist?(target)
        system("wget -O #{target} #{source}")
        File.chmod(mode, target) if mode

        puts "Done with #{target}."
      end
    end
  end
end